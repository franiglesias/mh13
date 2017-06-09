<?php

App::import('Vendor', 'InstallPanelTask');

class SchoolPanelTask extends InstallPanelTask
{
	
	var $domain = 'school';
	
	var	$menus = array(
			array(
				'Menu' => array(
					'title' => 'school_panel_1',
					'help' => 'Course organisation'
					),
				'MenuItem' => array(
					array(
						'label' => 'Stages',
						'url' => '/school/stages/index',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Cycles',
						'url' => '/school/cycles/index',
						'order' => 20,
						'access' => 2
						),
					array(
						'label' => 'Levels',
						'url' => '/school/levels/index',
						'order' => 30,
						'access' => 2
						),
					array(
						'label' => 'Sections',
						'url' => '/school/sections/index',
						'order' => 50,
						'access' => 2
						),
					array(
						'label' => 'Subjects',
						'url' => '/school/subjects/index',
						'order' => 60,
						'access' => 2
						)		
					
					)
				),
			array(
				'Menu' => array(
					'title' => 'school_panel_2',
					'help' => 'Students administration'
					),
				'MenuItem' => array(
					array(
						'label' => 'Students',
						'url' => '/school/students/index',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Applications',
						'url' => '/school/applications/index',
						'order' => 20,
						'access' => 2
						)		
					)
				),
		);
	
}

?>
