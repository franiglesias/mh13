<?php
class MenuItemsController extends MenusAppController {

	var $name = 'MenuItems';
	var $components = array('Filters.SimpleFilters');
	

	function index($menu_id = null) {
		
		if (!empty($menu_id)) {
			$this->paginate['MenuItem']['conditions'] = array('MenuItem.menu_id' => $menu_id);
		}
		$this->paginate['MenuItem']['order'] = array('MenuItem.order' => 'ASC');
		$this->paginate['MenuItem']['recursive'] = 0;
		$menus = $this->MenuItem->Menu->find('list');
		$this->set('filterAccessOptions', array(
				0 => __d('menus', 'Everyone', true),
				1 => __d('menus', 'Authenticated', true),
				2 => __d('menus', 'With permission to access the url', true),
				));
		$this->set('filterMenuOptions', $menus);
		$this->set('menuItems', $this->paginate());
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/index', 'ajax');
		}
	}

	function add($menu_id = false) {
		
		$this->setAction('edit', null, $menu_id);
	}

	function edit($id = null, $menu_id = false) {
		if (!empty($this->data)) { // 2nd pass
			if (!$id) { // Create a model
				$this->MenuItem->create();
			}
			// Try to save data, if it fails, retry
			if ($this->MenuItem->save($this->data)) {
				$this->message('success');
				if ($this->RequestHandler->isAjax()) {
					$this->redirect(array('action' => 'index', $this->data['MenuItem']['menu_id']));
				}
				$this->xredirect();
			} else {
				$this->message('validation');
			}
		}

		if(empty($this->data)) { // 1st pass
			if ($id) {
				if (!($this->data = $this->MenuItem->read(null, $id))) {
					$this->message('invalid');
                    // $this->Session->setFlash($invalid_message, 'alert');
					$this->xredirect(); // forget stored referer and redirect
				}
			} else {
				$this->data['MenuItem']['menu_id'] = $menu_id;
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render, prepare other data if needed
		$menus = $this->MenuItem->Menu->find('list');
		$this->set(compact('menus'));

		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/edit', 'ajax');
		}
	}

	function delete($id) {
		$this->MenuItem->id = $id;
		$menu_id = $this->MenuItem->field('menu_id');
		if ($this->MenuItem->delete($id, true)) {
			$this->message('delete');
			$this->xredirect($menu_id);
		}
		$this->message('error');	
		$this->xredirect($menu_id);
	}


	// function delete($id = null) {
	// 	$this->MenuItem->id = $id;
	// 	$menu_id = $this->MenuItem->field('menu_id');
	// 	if (!$this->MenuItem->delete($id)) {
    // 		$this->Session->setFlash(sprintf(__('%s was not deleted.', true), __d('menus', 'Menu Item', true)), 'alert');
	// 	} else {
    // 		$this->Session->setFlash(sprintf(__('%s was deleted.', true), __d('menus', 'Menu Item', true)), 'success');
	// 	}
	// 	if ($this->RequestHandler->isAjax()) {
	// 		$this->redirect(array('action' => 'index', $menu_id));
	// 	}
	// 	$this->redirect($this->referer());
	// }

}
?>