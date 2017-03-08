<?php
/**
 * ChannelsController.
 *
 * Description
 *
 * @version $Rev$
 *
 * @license MIT License
 *
 * $Id$
 *
 * $HeadURL$
 **/
class ChannelsController extends ContentsAppController
{
    public $name = 'Channels';
    public $helpers = array('Uploads.Upload', 'Access.Owner', 'Contents.Channel', 'Contents.Channels');
    public $components = array('Security', 'Filters.SimpleFilters', 'Ui.Ui');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(array('menu', 'icon_menu', 'view', 'last', 'media', 'site', 'tagged', 'tags', 'layouts', 'dashboard', 'readable', 'level', 'toggle', 'external', 'notmembers', 'members'));
        $this->selectionActions = array(
            'activate' => __d('contents', 'Activate Channel', true),
            'deactivate' => __d('contents', 'Deactivate Channel', true),
        );
        $this->Security->validatePost = false;

        if (!in_array($this->action, array('view', 'tagged', 'level'))) {
            return;
        }

        $this->Channel->getBySlug($this->params['pass'][0]);
        $this->Channel->load();

        if ($this->Channel->data['Channel']['private']) {
            if (!$this->Access->isAuthorizedToken($this->Channel)) {
                $this->Auth->deny($this->action);
            }
        }
    }

    /**
     * CRUD ACTIONS FOR BACKEND.
     */
    public function index()
    {
        $this->paginate['Channel'][0] = 'admin';
        if (!$this->Access->isAuthorizedToken('//contents/administrator')) {
            $this->paginate['Channel']['user'] = $this->Auth->user('id');
        }
        $this->set('channels', $this->paginate());
    }

    public function add()
    {
        $this->Channel->create();
        $this->Channel->init();
        $this->Channel->save(null, false);
        $this->Channel->bind($this->Access->user(), Channel::OWNER);
        $this->setAction('edit', $this->Channel->id);
    }

    public function edit($id = null)
    {
        if (!$this->Access->isAuthorizedToken('//contents/administrator')) {
            if (!$this->editableByUser($id)) {
                $this->message('invalid');
                $this->xredirect();
            }
        }
        if (!empty($this->data['Channel'])) { // 2nd pass
            if (!$id) { // Create a model
                $this->Channel->create();
            }
            // Try to save data, if it fails, retry
            if ($this->Channel->save($this->data)) {
                $slug = $this->Channel->read(array('slug'));
                $this->Channel->_deleteCache('channel_'.$slug['Channel']['slug']);
                $this->message('success');
                $this->xredirect();
                $this->refreshModel($id);
            } else {
                $this->message('validation');
            }
        }

        if (empty($this->data['Channel'])) { // 1st pass
            if ($id) {
                $this->refreshModel($id);
            }
            $this->saveReferer();
        }

        // Render, prepare other data if needed
        $theme = false;
        if (isset($this->data['Channel']['theme'])) {
            $theme = $this->data['Channel']['theme'];
        }
        $themes = $this->Ui->themes();
        $layouts = $this->Ui->layouts($theme, 'channel');
        $menus = $this->Channel->Menu->find('list');
        $licenses = $this->Channel->License->find('list');
        $roles = $this->Channel->Role->find('list');
        $sites = $this->Channel->Site->find('list');
        $this->set(compact('licenses', 'themes', 'menus', 'layouts', 'roles', 'sites'));
    }

    private function refreshModel($id)
    {
        $this->preserveAppData();
        $this->Channel->contain(array('OwnedBy', 'Role', 'Site'));
        if (!($this->data = $this->Channel->read(null, $id))) {
            $this->message('error');
            $this->xredirect(); // forget stored referer and redirect
        }
        $this->restoreAppData();
    }

    private function editableByUser($id)
    {
        $user = array(
            'owner_model' => 'User',
            'owner_id' => $this->Auth->user('id'),
        );
        if ($this->Channel->isOwner($user, $id)) {
            return true;
        }

        return false;
    }

    public function toggle($uid)
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect('/');
        }
        list($field, $id) = explode('_', $uid);
        $this->Channel->toggleField($field, $id);
        $this->Channel->id = $id;
        $this->set('value', $this->Channel->field($field));
        $this->set('uid', $id);
    }

    /**
     * Combined control to manage users tied to channels, via ajax.
     *
     * @param string $id
     */
    public function members($id = null)
    {
        if (!$this->RequestHandler->isAjax() && empty($this->params['requested'])) {
            $this->redirect('/');
        }
        $this->Channel->load($id);
        $this->set(array(
            'members' => $this->Channel->members(),
            'notMembers' => $this->Channel->notMembers(),
            'roles' => $this->Channel->roles,
            'id' => $this->Channel->getID(),
        ));
    }

    public function notmembers($id = null)
    {
        if (!$this->RequestHandler->isAjax() && empty($this->params['requested'])) {
            $this->redirect('/');
        }
        $this->Channel->load($id);

        foreach ($this->Channel->notMembersStartingWith($this->params['url']['term']) as $id => $fullname) {
            $notMembers[] = array(
                'value' => $id,
                'label' => $fullname,
            );
        }
        $this->set('notMembers', $notMembers);
        $this->render('ajax/notmembers', 'ajax');
    }

    /**
     * PUBLIC ACTIONS.
     */

    /**
     * Returns a list of items in a channel.
     *
     * @param string $slug:           the slug for the channel
     * @param string $stickyFeatured: if true, sorts the list keeping featured items in first places
     *
     * @return array if requested array with channel info and the items list
     */
    public function view($slug = null, $tag = null, $level_id = null)
    {
        $this->Channel->getBySlugAndUser($slug, $this->Auth->user('id'));
        if ($this->Channel->null()) {
            $this->message('invalid');
            $this->redirect('/');
        }

        $this->paginate['Item'] = array(
            0 => 'channel',
            'channel' => $slug,
        );
        if (!empty($tag)) {
            $this->paginate['Item']['label'] = $tag;
            $this->Channel->Label->setId($tag);
            $tag = $this->Channel->Label->field('title');
        }

        if (!empty($level_id)) {
            $this->paginate['Item']['level'] = $level_id;
        }

        $data = array(
            'channel' => $this->Channel->data,
            'items' => $this->paginate('Item'),
            'tag' => $tag,
            'level_id' => $level_id,
        );

        if (!empty($this->params['requested'])) {
            return $data;
        }

        $this->setThemeAndLayout();
        $this->set($data);
        $this->autoRender = false;
        echo $this->twig->render(
            'plugins/contents/channels/view.twig', [
                'channel' => $data['channel']['Channel'],
                'articles' => $data['items'],
            ]
        );
    }

    private function setThemeAndLayout()
    {
        if (!empty($this->Channel->data['Channel']['theme'])) {
            $this->theme = $this->Channel->data['Channel']['theme'];
        }
        if (!empty($this->Channel->data['Channel']['layout'])) {
            $this->layout = $this->Channel->data['Channel']['layout'];
        } else {
            $this->layout = 'channel';
        }
    }

    /**
     * Alternative view to show an index of the channel filtering by tag.
     */
    public function tagged($slug = null, $tag = null)
    {
        $this->setAction('view', $slug, $tag, null);
    }

    /**
     * Alternative view to show an index of the channel filtering by level.
     */
    public function level($slug = null, $level_id = null)
    {
        $this->loadModel('School.Level');
        $levels = $this->Level->find('list');
        $this->set(compact('levels'));
        $this->setAction('view', $slug, null, $level_id);
    }

    public function menu($site = false)
    {
        if ($site) {
            $channels = $this->Channel->findBySite($site, $this->Auth->user('id'));
        } else {
            $channels = $this->Channel->findActive($this->Auth->user('id'));
        }
        if (!empty($this->params['requested'])) {
            return $channels;
        }
        $this->layout = 'default';
        $this->set(compact('channels'));
    }

// Blocks

    /**
     * Get and returns the list of tags for a channel, given slug or id.
     *
     * @param string $slug The slug for the chanel. Could be the id
     *
     * @return array with list of tags
     */
    public function tags($id)
    {
        $tags = $this->Channel->labels($id);
        $this->autoRender = false;
        $max = array_reduce($tags, function ($max, $tag) {
            return $tag['Label']['weight'] > $max ? $tag['Label']['weight'] : $max;
        });
        echo $this->twig->render(
            'plugins/contents/channels/widgets/tags.twig', [
                'tags' => $tags,
                'max' => $max,
            ]

        );
    }

    /**
     * ACTIONS FOR MODULES.
     */

    /**
     * Retrieves the list of External channels (marked as general public interest).
     *
     * @return array
     *
     * @author Fran Iglesias
     */
    public function external()
    {
        $this->autoRender = false;
        echo $this->twig->render('plugins/contents/channels/external.twig', [
            'channels' => $this->Channel->findExternal(),
        ]);
    }

    /**
     * Retrieves channels where current user is member.
     *
     * @return array The list of channels, a CanCreate key if has rights to create channels
     */
    public function dashboard()
    {
        $IsBloggerToken = $this->Access->getResource('/contents/channels/index');
        if (!$this->Access->isAuthorized($IsBloggerToken)) {
            return 'disable';
        }
        $channels = $this->Channel->findMember($this->Auth->user('id'));
        $CanCreateBlogs = $this->Access->getResource('/contents/channels/add');
        $channels['CanCreate'] = $this->Access->isAuthorized($CanCreateBlogs);

        return $channels;
    }

    public function readable()
    {
        if (empty($this->params['requested'])) {
            $this->redirect('/');
        }

        $channels = array();
        foreach ($this->Channel->restricted() as $channelId) {
            $this->Channel->setId($channelId);
            $this->Channel->load();
            if ($this->Access->isAuthorizedToken($this->Channel)) {
                $channels[] = $this->Channel->data;
            }
        }

        return $channels;
    }

    /**
     * Pass layouts list to the view.
     */
    public function layouts()
    {
        $theme = $this->params['url']['key'];
        $layouts = $this->Ui->layouts($theme, 'channel');
        $this->set(compact('layouts'));
        $this->render('ajax/layouts', 'ajax');
    }

    /**
     * Selection actions.
     *
     * @param string $ids
     */
    public function _activate($ids)
    {
        $this->Channel->updateAll(array('Channel.active' => 1), array('Channel.id' => $ids));
        $this->Session->setFlash(sprintf(__d('contents', 'Selected %s set to %s', true), __d('contents', 'Channels', true), __d('contents', 'Active', true)), 'flash_success');
    }

    public function _deactivate($ids)
    {
        $this->Channel->updateAll(array('Channel.active' => 0), array('Channel.id' => $ids));
        $this->Session->setFlash(sprintf(__d('contents', 'Selected %s set to %s', true), __d('contents', 'Channels', true), __d('contents', 'Inactive', true)), 'flash_success');
    }
}
