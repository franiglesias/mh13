<?php

class MenusController extends MenusAppController
{
    public $name = 'Menus';

    public $helpers = array('Uploads.Upload');
    public $components = array('Filters.SimpleFilters');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(array('items', 'menu'));
    }

    /**
     * Return menu items for the logged user if any to build the menu in the menu element.
     *
     * @param string $menuTitle
     */
    public function items($menuTitle)
    {
        try {
            $menu = $this->Menu->getByTitle($menuTitle, $this->Auth->user('id'));
            $this->autoRender = false;
            return $this->render('plugins/menus/menu.twig', ['menu' => $menu]);
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    public function menu($id)
    {
        if (empty($this->params['requested'])) {
            $this->redirect('/');
        }
        try {
            return $this->Menu->get($id, $this->Auth->user('id'));
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    public function index($bar_id = null)
    {
        if (!empty($bar_id)) {
            $this->paginate['Menu']['conditions'] = array('Menu.bar_id' => $bar_id);
        }
        $this->paginate['Menu']['order'] = array('Menu.order' => 'ASC');
        $this->paginate['Menu']['recursive'] = 0;
        $menus = $this->Menu->find('all');
        $this->set('menus', $this->paginate());
        if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
            $this->render('ajax/index', 'ajax');
        }
    }

    public function add($bar_id = false)
    {
        $this->setAction('edit', null, $bar_id);
    }

    public function edit($id = null, $bar_id = false)
    {
        // Data needed to load or reload model
        $fields = null;
        // Second pass
        if (!empty($this->data['Menu'])) {
            // Create model if there is no id (add action)
            if (!$id) {
                $this->Menu->create();
            }
            // Try to save
            if ($this->Menu->save($this->data)) {
                $this->message('success');
                $this->xredirect($this->data['Menu']['bar_id']);
                // Force reload
                $this->preserveAppData();
                if (!($this->data = $this->Menu->read($fields, $id))) {
                    $this->message('invalid');
                    $this->xredirect(); // forget stored referer and redirect
                }
                $this->restoreAppData();
            } else {
                $this->message('validation');
            }
        }

        // First pass or reload
        if (empty($this->data['Menu'])) { // 1st pass
            if ($id) {
                $this->preserveAppData();
                if (!($this->data = $this->Menu->read($fields, $id))) {
                    $this->message('invalid');
                    $this->xredirect(); // forget stored referer and redirect
                }
                $this->restoreAppData();
            } else {
                $this->data['Menu']['bar_id'] = $bar_id;
            }
            $this->saveReferer(); // Store actual referer to use in 2nd pass
        }
        // Render preparation
        // Create lists for options, etc.
        $bars = $this->Menu->Bar->find('list');
        $this->set(compact('bars'));
        if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
            $this->render('ajax/edit', 'ajax');
        }
    }

    /**
     * Ajax actions to bind menus with menu bars.
     */

    /**
     * Bind a new menu with the current bar.
     *
     * @param string $bar_id
     */
    public function bar($bar_id = false)
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect('/');
        }

        if (!empty($this->data)) {
            if ($this->Menu->save($this->data)) {
                $this->xredirect($this->data['Menu']['bar_id']);
            }
        }

        if (empty($this->data)) {
            $this->data['Menu']['bar_id'] = $bar_id;
            $this->data['Menu']['order'] = $this->Menu->newPosition($bar_id);
        }
        $menus = $this->Menu->withoutBar();
        $this->set(compact('menus'));
        $this->render('ajax/bar', 'ajax');
    }

    /**
     * Change order/position of this menu.
     *
     * @param string $menu_id
     */
    public function move($id = false)
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect('/');
        }
        if (!empty($this->data)) {
            if ($this->Menu->save($this->data)) {
                $this->xredirect($this->data['Menu']['bar_id']);
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Menu->read(null, $id);
        }
        $this->render('ajax/move', 'ajax');
    }

    /**
     * Remove a menu from the bar.
     *
     * @param string $id
     */
    public function nobar($id)
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect('/');
        }

        $bar_id = $this->Menu->removeFromBar($id);
        $this->xredirect($bar_id);
    }

    public function delete($id)
    {
        $this->Menu->id = $id;
        $bar_id = $this->Menu->field('bar_id');
        if ($this->Menu->delete($id, true)) {
            $this->message('delete');
            $this->xredirect($bar_id);
        }
        $this->message('error');
        $this->xredirect($bar_id);
    }
}
