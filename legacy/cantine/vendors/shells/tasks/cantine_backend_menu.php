<?php

App::import('Vendor', 'InstallMenuAtBackendTask');

class CantineBackendMenuTask extends InstallMenuAtBackendTask
{
	var	$menus = array(
		array(
			'Menu' => array(
				'title' => 'cantine_admin',
				'label' => 'Cantine',
				'help' => 'Daily operations',
				'order' => '40'
				),
			'MenuItem' => array(
				array(
					'label' => 'Attendances',
					'url' => '/cantine/cantine/attendances',
					'help' => 'Manage attendances',
					'order' => 10,
					'access' => 2
					),
				array(
					'label' => 'Tickets',
					'url' => '/cantine/cantine_tickets/index',
					'help' => 'Manage tickets',
					'order' => 20,
					'access' => 2
					),
				array(
					'label' => 'Incidences',
					'url' => '/cantine/cantine_incidences/index',
					'help' => 'Manage Daily Incidences',
					'order' => 30,
					'access' => 2
					),
				array(
					'label' => '/',
					'order' => 100,
					'access' => 0,
				),
				array(
					'label' => 'Regulars',
					'url' => '/cantine/cantine_regulars/index',
					'help' => 'Manage cantine regulars',
					'order' => 110,
					'access' => 2
					),
				array(
					'label' => '/',
					'order' => 200,
					'access' => 0,
				),
				
				array(
					'label' => 'Menus',
					'url' => '/cantine/cantine_week_menus/index',
					'help' => 'Create and manage menus for the quarter',
					'order' => 210,
					'access' => 2
					),
				array(
					'label' => 'Changes',
					'help' => 'Add changes and remarks on per date basis',
					'url' => '/cantine/cantine_date_remarks/index',
					'order' => 220,
					'access' => 2
					),
				array(
					'label' => '/',
					'order' => 300,
					'access' => 0,
				),
				array(
					'label' => 'Turns',
					'url' => '/cantine/cantine_turns/index',
					'help' => 'Define Cantine Turns',
					'order' => 310,
					'access' => 2
					),
				array(
					'label' => 'Groups',
					'url' => '/cantine/cantine_groups/index',
					'help' => 'Define Cantine Groups',
					'order' => 320,
					'access' => 2
					),
				array(
					'label' => 'Students',
					'url' => '/school/students/index',
					'help' => 'Manage Student data',
					'order' => 330,
					'access' => 2
					),					
				array(
					'label' => 'Sections',
					'url' => '/school/sections/index',
					'help' => 'Manage School Sections',
					'order' => 340,
					'access' => 2
					)
				)
			),
		
		);
	
}

?>
