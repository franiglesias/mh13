<?php

/**
* 
*/
class InstallMenuAtBackendTask extends AppShell
{
	
	var $uses = array(
		'Menus.Menu',
		'Menus.Bar'
		);

	// Overwrite this vars
	var $menus = array();
	var $title = 'backend';
	
	function execute() {
		$this->out('Initializing '.$this->title.' Menu');
		App::import('Model', 'Menus.Bar');
		App::import('Model', 'Menus.Menu');
		$theMenu = ClassRegistry::init('Menu');
		$bar_id = ClassRegistry::init('Bar')->getIdFromTitle($this->title);
		if (!$bar_id) {
			$this->error('Bar not found: '.$this->title);
		}
		if (empty($this->menus)) {
			$this->error('No menus defined!');
		}
		$count = 0;
		foreach ($this->menus as $menu) {
			$theMenu->create();
			$count++;
			$menu['Menu']['bar_id'] = $bar_id;
			$theMenu->saveAll($menu);
			$this->out('Saved '.$menu['Menu']['label'].' menu.');
		}
		$this->hr();
	}
}

?>
