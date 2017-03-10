<?php

App::import('Lib', 'Circulars.CircularState');

class CircularsController extends CircularsAppController
{
    public $name = 'Circulars';
    public $layout = 'backend';
    public $helpers = array('Circulars.Circular', 'Circulars.Circulars', 'Circulars.Event', 'Ui.Pdf', 'Ui.Multilingual');
    public $statusOptions = array();
    public $components = array(
        'Menus.Panels',
        'Filters.SimpleFilters' => array('ignore' => 'Circular.pubDate-alt'),
        'State' => array(
            'Circulars.Circular' => array(
                Circular::DRAFT => 'DraftCircularState',
                Circular::PUBLISHED => 'PublishedCircularState',
                Circular::ARCHIVED => 'ArchivedCircularState',
                Circular::REVOKED => 'RevokedCircularState',
            ),
        ),
    );

    // Dependencies
    public $StateFactory;

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('*');
        $this->setJsVar('translate', Router::url(array(
            'plugin' => 'circulars',
            'controller' => 'circulars',
            'action' => 'translate',
        )));
    }

    public function index()
    {
        $this->paginate['Circular'][0] = 'year';
        $actionsSet = 'supervisor';
        if ($this->Access->isAuthorizedToken('//circulars/supervision')) {
            $actionsSet = 'supervisor';
            $this->paginate['Circular']['conditions']['Circular.status >='] = 0;
        } else {
            $this->paginate['Circular']['conditions']['Circular.creator_id'] = $this->Auth->user('id');
        }
        $this->set(compact('actionsSet'));
        $this->set('typeOptions', $this->Circular->CircularType->find('list'));
        $this->set('circulars', $this->paginate());
    }

    public function view($id = null)
    {
            $this->Circular->retrieve($id);
            $this->set('circular', $this->Circular->data);
            if ($this->params['url']['ext'] == 'pdf') {
                $this->viewPath = 'uploads/pdf';
                $this->setAssets();
                $this->set('show', true);
            }
        return $this->render('plugins/circulars/view.twig', [
            'circular' => $this->Circular->data
        ]);

    }

    private function setAssets()
    {
        $assets = 'img' . DS . 'assets' . DS;
        if (!empty($this->theme)) {
            $assets = VIEWS . 'themed' . DS . $this->theme . DS . 'webroot' . DS . $assets;
        }
        $this->set('assets', $assets);
    }

    public function review($id = null)
    {
        try {
            $this->layout = 'basic';
            $this->Circular->retrieve($id);
            $this->set('circular', $this->Circular->data);
        } catch (Exception $e) {
            $this->message('invalid');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function preview($id = null)
    {
        try {
            $this->Circular->retrieve($id);
            $this->set('circular', $this->Circular->data);
            $this->set('show', true);
            $this->setAssets();
            $this->render('pdf/view');
            $this->Circular->deleteFile($id);
        } catch (Exception $e) {
            $this->message('invalid');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function add()
    {
        if (!empty($this->data['Circular'])) {
            $this->Circular->create(); // 2nd pass
            $this->Circular->init($this->data['Circular']['circular_type_id'], $this->Auth->user('id'));
            if ($this->Circular->saveAll()) {
                $this->data['Circular'] = false;
                $this->setAction('edit', $this->Circular->getInsertID());
            } else {
                $this->message('validation');
            }
        } else {
            $this->saveReferer();
        }
        $this->set('circularTypes', $this->Circular->CircularType->find('list'));
    }

    public function edit($id = null)
    {
        if (!empty($this->data['Circular'])) {
            if (!$id) {
                $this->Circular->create(); // 2nd pass
            }
            $saveModels = array('Circular' => true, 'Event' => true);
            if (isset($this->data['Event']) && isset($this->data['Circular']['title'])) {
                $this->data['Event']['title'] = $this->data['Circular']['title'];
            }
            // Remove models
            $dataToSave = array_intersect_key($this->data, $saveModels);
            // Try to save data, if it fails, retry
            if ($result = $this->Circular->saveAll($dataToSave)) {
                $this->message('success');
                $this->xredirect();
                $this->refreshModel($id);
            } else {
                $this->message('validation');
            }
        }
        if (empty($this->data['Circular'])) { // 1st pass
            if ($id) {
                $this->refreshModel($id);
            }
            $this->saveReferer();
        }
        $circularBoxes = $this->Circular->CircularBox->find('list');
        $this->set(compact('circularBoxes'));
    }

    protected function refreshModel($id)
    {
        $this->preserveAppData();
        $contains = array('CircularType', 'CircularBox', 'Event', 'Creator', 'Publisher', 'Archiver', 'Revoker');
        $this->Circular->contain($contains);
        if (!($this->data = $this->Circular->get(null, $id))) {
            $this->message('invalid');
            $this->xredirect();
        }
        if (!empty($this->data['Event']['id'])) {
            $event = $this->Circular->Event->get(null, $this->data['Event']['id']);
            $this->data['Event'] = $event['Event'];
        }
        if ($this->data['Circular']['status'] == 2) {
            $this->message('invalid');
            $this->xredirect();
        }
        $this->restoreAppData();
    }

    public function translate()
    {
        $from = $this->AjaxRequest->getParam('sl') == 'spa' ? 'es' : 'gl';
        $to = $this->AjaxRequest->getParam('tl') == 'spa' ? 'es' : 'gl';

        App::import('Lib', 'FiText');
        $T = ClassRegistry::init('FiText');
        $this->set('translated', $T->translate($this->AjaxRequest->getParam('text'), $from, $to));
        $this->layout = 'ajax';
    }

    public function duplicate($id)
    {
        $newID = $this->Circular->duplicate($id, array(
            'cascade' => false,
            // 'associations' => array('Event'),
            'whitelist' => array(
                'circular_type_id',
                'circular_box_id',
                'pubDate',
                'web',
            ),
            'callbacks' => true,
            'changeFields' => array('title'),
            'changeString' => 'Copy of %s',
        ));
        if (!$newID) {
            $this->redirect($this->referer());
        }
        $this->Circular->id = $newID;
        $this->Circular->saveField('creator_id', $this->Auth->user('id'));
        $this->redirect(array('action' => 'edit', $newID));
    }

    public function delete($id = null)
    {
        $this->Circular->deleteFile($id);
        parent::delete($id);
    }

    public function revoke($id = null)
    {
        $this->Circular->id = $id;
        $State = $this->State->get($this->Circular->field('status'));
        $State->revoke($this->Circular, $this->Auth->user('id'), $id);
        $this->set('circular', $this->Circular->load($id));
        $this->render('ready');
    }

    public function next($id = null)
    {
        $this->Circular->id = $id;
        $State = $this->State->get($this->Circular->field('status'));
        $State->next($this->Circular, $this->Auth->user('id'), $id);
        $this->set('circular', $this->Circular->load($id));
        $this->render('ready');
    }

    public function draft($id = null)
    {
        $this->Circular->id = $id;
        $State = $this->State->get($this->Circular->field('status'));
        $State->draft($this->Circular, $this->Auth->user('id'), $id);
        $this->set('circular', $this->Circular->load($id));
        $this->render('ready');
    }

    public function toggle($uid)
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect('/');
        }
        list($field, $id) = explode('_', $uid);
        $this->Circular->toggleField($field, $id);
        $this->Circular->id = $id;
        $this->set('value', $this->Circular->field($field));
        $this->set('uid', $id);
    }

    public function current($stage = null)
    {
        $this->paginate['Circular'][0] = 'current';
        if ($this->isRequestedViaAjax()) {
            $this->paginate['Circular'][0] = 'widget';
        }

        if (!is_null($stage)) {
            $this->paginate['Circular']['stage'] = $stage;
        }

        $circulars = $this->paginate();
        if (isset($this->params['requested'])) {
            return $circulars;
        }
        $template = $this->isRequestedViaAjax() ?
            'plugins/circulars/ajax/current.twig' :
            'plugins/circulars/current.twig';

        return $this->render(
            $template, [
                'circulars' => $circulars,
            ]);
    }

    public function generate($id = null)
    {
        if (!$this->params['requested']) {
            $this->xredirect();
        }
        $this->setAssets();
        $circular = $this->Circular->load($id);
        $this->set(compact('circular', 'assets'));
        $this->set('show', false);
        $this->render('pdf/view');
    }
}
