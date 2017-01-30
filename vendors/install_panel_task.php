<?php

/**
* 
*/
class InstallPanelTask extends AppShell
{
	
	var $uses = array(
		'Menus.Menu',
		);

	// Overwrite this vars
	var $menus = array();
	var $domain = null;
	
	function execute() {
		
		if (empty($this->domain)) {
			$this->error('Domain needed!');
		}
		
		$this->out('Initializing '.$this->domain.' Panel System');
		$this->hr();
		
		if (in_array('reset', $this->args)) {
			$this->out('Resetting '.$this->domain.' panels.');
			$this->Menu->deleteAll(array('title LIKE ' => $this->domain.'_panel_%'));
		}
		
		if (empty($this->menus)) {
			$this->error('No menus defined!');
		}
		
		$count = 0;
		foreach ($this->menus as $menu) {
			$this->Menu->create();
			$count++;
			$menu['Menu']['title'] = $this->domain.'_panel_'.$count;
			$this->Menu->saveAll($menu);
			$this->out('Saved '.$menu['Menu']['title']);
		}
		
		$this->hr();
	}
}

?>
