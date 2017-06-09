<?php

class StaticPagesController extends ContentsAppController
{
    public $name = 'StaticPages';
    public $layout = 'backend';
    public $components = array('Filters.SimpleFilters');
    public $helpers = array('Contents.StaticPage', 'Ui.Images', 'Ui.Image');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(array('view', 'images', 'home'));
    }

    public function index()
    {
        $this->StaticPage->recursive = 0;
        $this->set('staticPages', $this->paginate());
        $this->set('allPages', $this->StaticPage->findAllParents());
        $this->passLabelsToView();
    }

    protected function passLabelsToView()
    {
        // App::import('Model', 'Labels.Label');
        $this->loadModel('Labels.Label');
        $this->set(
            'globalLabels',
            $this->Label->getGlobal()
        );
    }

    public function view($slug = null)
    {
        $this->layout = 'static';
        if (!$slug) {
            $this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('contents', 'site', true)), 'alert');
            $this->redirect(array('action' => 'index'));
        }
        $this->StaticPage->view($slug);
        $this->autoRender = false;
        return $this->render('plugins/contents/static_pages/view.twig', ['staticPage' => $this->StaticPage->data]);
    }

    public function home($slug = null)
    {
        $this->setAction('view', $slug);
    }

    public function add()
    {
        $data = array(
            'title' => __d('contents', 'New page', true),
            'content' => __d('contents', 'Content for the page', true),
        );
        $this->StaticPage->create();
        $this->StaticPage->save($data);
        $this->setAction('edit', $this->StaticPage->id);
    }

    public function edit($id = null)
    {
        // Second pass
        if (!empty($this->data['StaticPage'])) {
            // Create model if there is no id (add action)
            if (!$id) {
                $this->StaticPage->create();
            }
            // Data massaging if it is not doable in create or beforeSave

            // Try to save
            if ($this->StaticPage->save($this->data)) {
                $this->message('success');
                $this->xredirect();
                // Force reload
                $this->refreshModel($id);
            } else {
                $this->message('validation');
            }
        }

        // First pass or reload
        if (empty($this->data['StaticPage'])) { // 1st pass
            if ($id) {
                $this->refreshModel($id);
            }
            $this->saveReferer(); // Store actual referer to use in 2nd pass
        }
        // Render preparation
        // Create lists for options, etc.
        $this->_useAutosave();
        $staticParents = $this->StaticPage->candidateParents();
        $this->passLabelsToView();
        $this->set(compact('staticParents'));
    }

    protected function refreshModel($id)
    {
        $this->preserveAppData();
        // Data needed to load or reload model
        $fields = null;
        if (!($this->data = $this->StaticPage->read($fields, $id))) {
            $this->message('error');
            $this->xredirect(); // forget stored referer and redirect
        }
        $this->restoreAppData();
    }
}
