<?php

App::import('Vendor', 'InstallMenuAtBackendTask');

class AdminBackendMenuTask extends InstallMenuAtBackendTask
{
	var	$menus = array(
			array(
				'Menu' => array(
					'title' => 'site_admin',
					'label' => 'Site Admin',
					'help' => 'General Site Administration',
					'order' => 20
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
						),
					array(
						'label' => '/',
						'order' => 100,
						'access' => 0
						),
					array(
						'label' => 'Users',
						'url' => '/access/users/index',
						'order' => 110,
						'access' => 2
						),
					array(
						'label' => 'Roles',
						'url' => '/access/roles/index',
						'order' => 120,
						'access' => 2
						),
					array(
						'label' => 'Tickets',
						'url' => '/tickets/tickets/index',
						'order' => 130,
						'access' => 2
						)
							
					)
				)
		);
	
}

?>
