<?php

class BarsController extends MenusAppController
{
    public $name = 'Bars';

    public $helpers = array('Menus.Bar', 'Menus.Menus', 'Menus.Menu');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('bar', 'menubar');
    }

    public function index()
    {
        $this->Bar->recursive = 0;
        $this->set('bars', $this->paginate());
    }

    public function add()
    {
        $this->setAction('edit');
    }

    public function edit($id = null)
    {
        // Data needed to load or reload model
        $fields = null;
        // Second pass
        if (!empty($this->data['Bar'])) {
            // Create model if there is no id (add action)
            if (!$id) {
                $this->Bar->create();
            }
            // Try to save
            if ($this->Bar->save($this->data)) {
                $this->message('success');
                $this->xredirect();
                // Force reload
                $this->preserveAppData();
                if (!($this->data = $this->Bar->read($fields, $id))) {
                    $this->message('error');
                    $this->xredirect(); // forget stored referer and redirect
                }
                $this->restoreAppData();
            } else {
                $this->message('validation');
            }
        }
        // First pass or reload
        if (empty($this->data['Bar'])) { // 1st pass
            if ($id) {
                $this->preserveAppData();
                if (!($this->data = $this->Bar->read($fields, $id))) {
                    $this->message('error');
                    $this->xredirect(); // forget stored referer and redirect
                }
                $this->restoreAppData();
            }
            $this->saveReferer(); // Store actual referer to use in 2nd pass
        }
    }

    public function bar($bar)
    {
        if ($this->params['requested']) {
            return $this->Bar->getByTitle($bar, $this->Auth->user('id'));
            // return $this->Bar->find('bar', array('bar' => $bar, 'user_id' => $this->Auth->user('id')));
        }
    }

    public function menubar($bar)
    {
        $this->autorender = false;
        $data = $this->Bar->getByTitle($bar, $this->Auth->user('id'));

        echo $this->twig->render('plugins/menus/bars/menubar.twig', ['menubar' => $data]);
        // $this->set(compact('data'));
    }
}
