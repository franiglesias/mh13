<?php

App::import('Vendor', 'InstallPanelTask');

class ItPanelTask extends InstallPanelTask
{
	var $domain = 'it';
	var	$menus = array(
			array(
				'Menu' => array(
					'title' => 'it_panel_1',
					'help' => 'Devices administration'
					),
				'MenuItem' => array(
					array(
						'label' => 'Add a new device',
						'url' => '/it/devices/add',
						'order' => 30,
						'access' => 2
						),
					array(
						'label' => 'Manage devices',
						'url' => '/it/devices/index',
						'order' => 20,
						'access' => 2
						)		
					)
				),
			array(
				'Menu' => array(
					'title' => 'it_panel_2',
					'help' => 'IT administration'
					),
				'MenuItem' => array(
					array(
						'label' => 'Manage Device Types',
						'url' => '/it/device_types/index',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Manage Maintenances',
						'url' => '/it/maintenances/index',
						'order' => 20,
						'access' => 2
						),
					array(
						'label' => 'Manage Maintenance Types',
						'url' => '/it/maintenance_types/index',
						'order' => 15,
						'access' => 2
						),		
					)
				)
		);
}

?>
