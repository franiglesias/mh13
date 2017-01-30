<?php

App::import('Vendor', 'InstallPanelTask');

class AdminPanelTask extends InstallPanelTask
{
	
	var $domain = 'admin';
	
	var	$menus = array(
			array(
				'Menu' => array(
					'title' => 'admin_panel_1',
					'help' => 'General Site Administration'
					),
				'MenuItem' => array(
					array(
						'label' => 'Menus',
						'url' => '/menus/menus/index',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Licenses',
						'url' => '/licenses/licenses/index',
						'order' => 20,
						'access' => 2
						)		
					)
				)
		);
	
}

?>
