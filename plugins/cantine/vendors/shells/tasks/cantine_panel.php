<?php
App::import('Vendor', 'InstallPanelTask');

class CantinePanelTask extends InstallPanelTask
{

	var $domain = 'cantine';
	var $menus = array(
			array(
				'Menu' => array(
					'title' => 'cantine_panel_1',
					'help' => 'Daily operations'
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
						)
					)
				),
			array(
				'Menu' => array(
					'title' => 'cantine_panel_2',
					'help' => 'Regulars management'
					),
				'MenuItem' => array(
					array(
						'label' => 'Regulars',
						'url' => '/cantine/cantine_regulars/index',
						'help' => 'Manage cantine regulars',
						'order' => 10,
						'access' => 2
						),
					)
				),
			array(
				'Menu' => array(
					'title' => 'cantine_panel_3',
					'help' => 'Menu management'
					),
				'MenuItem' => array(
					array(
						'label' => 'Menus',
						'url' => '/cantine/cantine_week_menus/index',
						'help' => 'Create and manage menus for the quarter',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Changes',
						'help' => 'Add changes and remarks on per date basis',
						'url' => '/cantine/cantine_date_remarks/index',
						'order' => 20,
						'access' => 2
						),
					)
				),
			array(
				'Menu' => array(
					'title' => 'cantine_panel_4',
					'help' => 'Organization'
					),
				'MenuItem' => array(
					array(
						'label' => 'Turns',
						'url' => '/cantine/cantine_turns/index',
						'help' => 'Define Cantine Turns',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Groups',
						'url' => '/cantine/cantine_groups/index',
						'help' => 'Define Cantine Groups',
						'order' => 20,
						'access' => 2
						),
					array(
						'label' => 'Students',
						'url' => '/school/students/index',
						'help' => 'Manage Student data',
						'order' => 30,
						'access' => 2
						),					
					array(
						'label' => 'Sections',
						'url' => '/school/sections/index',
						'help' => 'Manage School Sections',
						'order' => 40,
						'access' => 2
						),
					)
				),

		);
		
}

?>
