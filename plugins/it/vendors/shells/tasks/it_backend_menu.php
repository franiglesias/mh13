<?php

App::import('Vendor', 'InstallMenuAtBackendTask');

class ItBackendMenuTask extends InstallMenuAtBackendTask
{
	var	$menus = array(
		array(
			'Menu' => array(
				'title' => 'it_admin',
				'help' => 'Devices administration',
				'order' => 50,
				'label' => 'IT',
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
					),
				array(
					'label' => '/',
					'order' => 100,
					'access' => 0
					),
				array(
					'label' => 'Manage Device Types',
					'url' => '/it/device_types/index',
					'order' => 110,
					'access' => 2
					),
				array(
					'label' => 'Manage Maintenances',
					'url' => '/it/maintenances/index',
					'order' => 120,
					'access' => 2
					),
				array(
					'label' => 'Manage Maintenance Types',
					'url' => '/it/maintenance_types/index',
					'order' => 115,
					'access' => 2
					)
				)
			)

		);
	
}

?>
