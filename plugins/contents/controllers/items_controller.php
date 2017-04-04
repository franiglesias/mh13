<?php

// Last version

class ItemsController extends ContentsAppController
{
    public $name = 'Items';

    public $helpers = array(
        'Uploads.Upload',
        'Access.Owner',
        'Comments.Comment',
        'Ui.Images',
        'Ui.Image',
    );

    public $components = array('Security', 'Filters.SimpleFilters', 'Notify');
    /**
     * Contains the type of role to select the right view.
     *
     * @var string
     */
    public $role;

    public function beforeFilter()
    {

        parent::beforeFilter();
        $this->Auth->allow(
            array(
                'view',
                'show',
                'last',
                'featured',
                'feed',
                'titles',
                'image',
                'media',
                'catalog',
                'tagged',
                'channel',
                'search',
                'dashboard',
                'comments',
                'readings',
            )
        );
        $this->Security->validatePost = false;

        $this->selectionActions = array(
            'statusToDraft' => __d('contents', 'Change status to Draft', true),
            'statusToExpired' => __d('contents', 'Change status to Expired', true),
            'statusToPublish' => __d('contents', 'Change status to Publish', true),
            'selectionDelete' => __d('contents', 'Delete', true),
        );


    }

    public function readings($id)
    {
        if (!$this->itemWasVisited()) {
            $this->Item->updateReadingCount();
            $this->updateVisitedSessionRegistry();
        }
        $this->set('readings', $this->Item->getReadings($id));
        $this->render('ajax/readings', 'ajax');
    }

    private function itemWasVisited()
    {
        $visited = $this->Session->read('Items.visited');

        return is_array($visited) && in_array($this->Item->getID(), $visited);
    }

    private function updateVisitedSessionRegistry()
    {
        $visited = $this->Session->read('Items.visited');
        $visited[] = $this->Item->getID();
        $this->Session->write('Items.visited', $visited);
    }

    /**
     * Generates the feed for a given Channel.
     *
     * @param string $channel_slug
     */
    public function feed($slug = false)
    {
        if (!$this->RequestHandler->prefers('rss')) {
            $this->redirect($this->referer());
        }

        $Feed = new FeedBuilder();

        return $this->render('plugins/contents/items/rss/feed.twig', $Feed->getFeed($this->Item, $this->params));
    }

    /**
     * Returns a list of recent entries in the global, site or channel context.
     *
     * @return string rendered fragment
     *
     * @param named offset integer offset to select items
     * @param named limit integer max number of items to retrieve
     * @param named site string The site to get the items from
     * @param named channel string Channel id to get the items from
     * @param named sticky boolean Order items so sticky/featured appear at first positions
     * @param named featured boolean Retrieve only featured items
     * @param named paginate boolean Use paginate method (true) or standard find
     */
    public function catalog()
    {
        return $this->render(
            'plugins/contents/items/catalog.twig',
            [
                'items' => $this->Item->select($this->params['named']),
                'layout' => $this->params['named']['layout'],
            ]
        );
    }

    /**
     * Previews an Item.
     *
     * @param string $slug
     */
    public function preview($id = null)
    {
        if (!$id) {
            $this->message('invalid');
            $this->redirect($this->referer());
        }
        $this->Item->retrieve($id);
        $this->set('preview', true);

        return $this->setAction('show');
    }

    /**
     * Shows an Item.
     *
     * @param string $slug
     */
    public function view($slug = null)
    {
        try {
            $this->helpers[] = 'Cache';
            $this->Item->getBySlugOrFail($slug);

            if ($this->Item->isInPrivateChannel()) {
                if (!$this->Access->isAuthorizedToken($this->Item->Channel)) {
                    $this->Auth->deny($this->action);
                }
            } elseif ($this->Item->isRestricted()) {
                $this->authenticate();
            }

            return $this->setAction('show');
        } catch (Exception $exception) {
            $this->message('invalid');
            $this->redirect($this->referer());
        }
    }

    protected function authenticate()
    {
        $credentials = $this->Item->credentials();
        $this->Security->loginOptions = array(
            'type' => 'basic',
            'realm' => __d('contents', 'You need a password to see this item.', true),
        );
        $this->resetHttpAuth($credentials);
        $this->Security->loginUsers = array($credentials['guest'] => $credentials['guestpwd']);
        $this->Security->blackHoleCallback = 'notAllowed';
        $this->Security->requireLogin($this->action);
    }

    public function show()
    {
        $this->setTheme();
        $data = array(
            'item' => $this->Item->data,
            'showExtras' => $this->Item->hasExtras(),
            'backToIndex' => $this->backLink(),
            'neighbors' => $this->Item->neighbors(),
        );

        return $this->render('plugins/contents/items/view.twig', $data);
    }

    private function setTheme()
    {
        if ($this->Item->data['Channel']['theme']) {
            $this->theme = $this->Item->data['Channel']['theme'];
        }
    }

    private function backLink()
    {
        // Retrieve index filtering if present (referer URL includes tagged)
        if (strpos($this->referer(), '/tagged/') > 0) {
            return $this->referer();
        }

        return array(
            'plugin' => 'contents',
            'controller' => 'channels',
            'action' => 'view',
            $this->Item->data['Channel']['slug'],
        );
    }

    /**
     * Implements search for Items. Preserves pagination data via Session.
     */
    public function search()
    {
        if (!$this->data) {
            if (!($term = $this->Session->read('Search.term'))) {
                $this->redirect($this->referer());
            }
        } else {
            $term = $this->data['Sindex']['term'];
            $this->Session->write('Search.term', $term);
        }
        $this->paginate['Item'] = $this->Item->buildSearchQuery($term);

        $items = $this->paginate('Item');

        $this->layout = 'default';
        $this->set(compact('items', 'term'));
    }

    /**
     * Administrative index. Select only items owned by the current user.
     */
    public function index()
    {
        if (!empty($this->params['named']['channel_id'])) {
            $this->SimpleFilters->setFilter('Item.channel_id', $this->params['named']['channel_id']);
            unset($this->params['named']['channel_id']);
        }
        // Check that Global Contents Administrator have access to all items
        if (!$this->Access->isAuthorizedToken('//contents/administrator')) {
            $channels = $this->Item->Channel->findAvailable($this->Auth->user('id'));
            $this->paginate['Item'][0] = 'user';
            $this->paginate['Item']['user'] = $this->Auth->user('id');
        } else {
            $channels = $this->Item->Channel->findAvailable();
        }
        $this->paginate['Item']['order']['pubDate'] = 'desc';
        $this->set('filterChannelsOptions', $channels);
        $this->set('items', $this->paginate('Item'));
        $this->_prepareLists();
    }

    /**
     * Backend actions.
     */

    /**
     * Prepare common data lists for some views.
     */
    protected function _prepareLists()
    {
        App::import('Model', 'School.Level');
        $this->set(
            array(
                'licenses' => $this->Item->License->find('list'),
                'levels' => ClassRegistry::init('Level')->find('list'),
            )
        );
        if ($this->Access->isAuthorizedToken('//contents/administrator')) {
            $this->set('channels', $this->Item->Channel->listActive());
        } else {
            $this->set('channels', $this->Item->Channel->findAvailable($this->Auth->user('id')));
        }
    }

    /**
     * By means of Duplicable Behavior, duplicates a Model record and reset some values. Then transfer to edit action.
     *
     * @param string $id
     */
    public function duplicate($id)
    {
        $newID = $this->Item->duplicate($id);
        if (!$newID) {
            $this->redirect($this->referer());
        }

        $this->Item->setId($newID);
        $this->role = $this->Item->getRoleForUser($this->Access->user());
        $this->Item->setAuthor($this->Access->user(), Item::AUTHOR);
        $this->redirect(array('action' => 'edit', $newID));
    }

    public function add()
    {
        if (empty($this->data['Item'])) {
            $this->jumpToEditIfOnlyOneChannelAvailable();
        }
        if (!empty($this->data['Item'])) {
            $this->Item->create();
            $this->Item->init($this->data['Item']['channel_id']);
            if ($this->Item->save()) {
                $this->role = $this->Item->getRoleForUser($this->Access->user());
                $this->Item->setAuthor($this->Access->user(), Item::AUTHOR);
                $this->message('success');
                unset($this->data['Item']);
                $this->setAction('edit', $this->Item->id);
            } else {
                $this->message('validation');
            }
        }
        $this->saveReferer();
        $this->_prepareLists();
    }

    private function jumpToEditIfOnlyOneChannelAvailable()
    {
        $channels = $this->Item->Channel->findAvailable($this->Auth->user('id'));
        if (count($channels) == 1) {
            $this->data['Item']['channel_id'] = key($channels);
        }
    }

    public function edit($id = null)
    {
        if (!$id && empty($this->data['Item'])) {
            $this->message('invalid');
            $this->xredirect();
        }
        if ($this->Access->isAuthorizedToken('//contents/administrator')) {
            $this->role = 'editor';
        } else {
            $this->role = $this->Item->getRoleForUser($this->Access->user());
        }

        if (!empty($this->data['Item'])) {
            if ($this->Item->save($this->data)) {
                if ($this->role == 'contributor' && $this->data['Item']['status'] == 1) {
                    $this->_notifyNewItemToEditors($this->data);
                }
                $this->message('success');
                $this->xredirect();
                $this->refreshModel($id);
            } else {
                $this->message('validation');
            }
        }
        if (empty($this->data['Item'])) {
            if ($id) {
                $this->refreshModel($id);
            }
            $this->saveReferer();
        }
        $this->_useAutosave();
        $this->_prepareLists();
        $this->set('role', $this->role);
        $this->passLabelsToView();
        $this->Access->isAuthorizedToken('//contents/administrator');
    }

    /**
     * Gets all data needed to send a notification about a new Item pending for review to all editors in a channel.
     *
     * @param string $item
     */
    protected function _notifyNewItemToEditors($item)
    {
        $this->Item->Channel->load($item['Item']['channel_id']);
        $to = Set::extract('/User/email', $this->Item->Channel->editors());
        $user = $this->Auth->user();
        // $channel = $this->Item->Channel->read(null, $item['Item']['channel_id']);
        $channel = $this->Item->Channel->data;
        $this->set(compact('user', 'channel', 'item'));
        $this->Notify->send('item_created', $to, 'New Item in your Channel');
    }

    /**
     * Loads model data.
     *
     * @param string $id
     *
     * @author Fran Iglesias
     */
    protected function refreshModel($id)
    {
        $this->preserveAppData();
        if (!($this->data = $this->Item->read(null, $id))) {
            $this->message('invalid');
            $this->xredirect(); // forget stored referer and redirect
        }
        App::import('Model', 'Labels.Labelled');
        $labels = ClassRegistry::init('Labelled')->find(
            'all',
            array(
                'conditions' => array(
                    'model' => 'Item',
                    'foreign_key' => $id,
                ),
            )
        )
        ;
        $this->data['Label'] = Set::extract('/Labelled/label_id', $labels);
        $this->restoreAppData();
    }

    protected function passLabelsToView()
    {
        App::import('Model', 'Labels.Label');
        $this->Item->Channel->setId($this->data['Item']['channel_id']);
        $this->set(
            array(
                'globalLabels' => ClassRegistry::init('Label')->getGlobal(),
                'channelLabels' => ClassRegistry::init('Label')->getModel($this->Item->Channel),
            )
        );
    }

    public function members($id)
    {
        $this->Item->setId($id);
        $this->set(
            array(
                'members' => $this->Item->authors(),
                'notMembers' => $this->Item->notAuthors(),
                'id' => $this->Item->getID(),
            )
        );
    }

    /**
     * Edit variations depending on user role in the channel.
     *
     * @param string $id
     */
    public function author_edit($id = null)
    {
        $this->layout = 'backend';
        $this->role = 'author';
        $this->setAction('edit', $id);
    }

    public function contributor_edit($id = null)
    {
        $this->layout = 'backend';
        $this->role = 'contributor';
        $this->setAction('edit', $id);
    }

    public function dashboard()
    {
        if (empty($this->params['requested'])) {
            $this->redirect('/');
        }
        if (!$this->Access->isAuthorizedToken('//contents/administrator')) {
            return 'disable';
        }

        $items = $this->Item->find('dashboard', array('user' => $this->Auth->user('id')));
        $items['CanCreate'] = $this->Access->isAuthorizedToken('/contents/items/add');

        return $items;
    }

    public function channel()
    {
        $this->Session->setFlash(sprintf(__('Invalid %s', true), 'item'), 'alert');
        $this->redirect($this->referer());
    }

    public function toggle($uid)
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect('/');
        }
        list($field, $id) = explode('_', $uid);
        $this->Item->toggleField($field, $id);
        $this->Item->id = $id;
        $this->set('value', $this->Item->field($field));
        $this->set('uid', $id);
        $this->Item->removeCache($id);
    }

    /**
     * Get the list of comments pending of approval for the logged user.
     */
    public function comments()
    {
        if (empty($this->params['requested'])) {
            $this->redirect('/');
        }

        if (!$this->Access->isAuthorizedToken('/comments/comments/index')) {
            return 'disable';
        }
        $user_id = $this->Auth->user('id');
        $result = $this->Item->find('responsible', array('user' => $user_id));
        $ids = Set::extract($result, '/Item/id');
        $conditions = array('Comment.object_fk' => $ids, 'Comment.object_model' => 'Item', 'Comment.approved' => 0);
        $comments = array();

        // $comments = $this->Item->Comment->find('all', compact('conditions'));
        return $comments;
    }

    protected function updateReadingCount()
    {
        if (!$this->itemWasVisited()) {
            $this->Item->updateReadingCount();
            $this->updateVisitedSessionRegistry();
        }
    }

    /**
     * Actions for selections.
     *
     * @param string $ids
     */
    protected function _statusToDraft($ids)
    {
        $this->Item->updateAll(array('Item.status' => 0), array('Item.id' => $ids));
        $this->Session->setFlash(
            sprintf(
                __d('contents', 'Selected %s set to %s', true),
                __d('contents', 'Items', true),
                __d('contents', 'draft', true)
            ),
            'success'
        );
        $this->Item->removeCache($ids);
    }

    protected function _statusToExpired($ids)
    {
        $this->Item->updateAll(array('Item.status' => 3), array('Item.id' => $ids));
        $this->Session->setFlash(
            sprintf(
                __d('contents', 'Selected %s set to %s', true),
                __d('contents', 'Items', true),
                __d('contents', 'expired', true)
            ),
            'success'
        );
        $this->Item->removeCache($ids);
    }

    protected function _statusToPublish($ids)
    {
        $this->Item->updateAll(array('Item.status' => 2), array('Item.id' => $ids));
        $this->Session->setFlash(
            sprintf(
                __d('contents', 'Selected %s set to %s', true),
                __d('contents', 'Items', true),
                __d('contents', 'published', true)
            ),
            'success'
        );
        $this->Item->removeCache($ids);
    }

    protected function _selectionDelete($ids)
    {
        $this->Item->deleteAll(array('Item.id' => $ids));
        $this->Session->setFlash(sprintf(__('Selected %s deleted', true), __d('contents', 'Items', true)), 'success');
        $this->Item->removeCache($ids);
    }
}
