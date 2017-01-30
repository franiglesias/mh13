<?php

/**
* 
*/
class PanelsComponent extends Object {
	
	var $controller;
	
	public function startup(&$controller) {
		$this->controller = $controller;
	}
	
	public function panel($domain) {
		App::import('Model', 'Menus.MenuItem');
		$user_id = $this->controller->Auth->user('id');
		$Menu = ClassRegistry::init('MenuItem');
		$names = $Menu->Menu->find('all', array(
			'fields' => array('title'),
			'conditions' => array('title LIKE' => $domain.'_panel_%'), 
			'order' => array('title' => 'asc')
		));
		foreach ($names as $name) {
			$panels[] = $Menu->find('available', array('menu' => $name['Menu']['title'], 'user_id' => $user_id));
		}
		$this->controller->set(compact('panels'));
		
	}
}


?>