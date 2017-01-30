<?php

App::import('Vendor', 'InstallPanelTask');

class CircularsPanelTask extends InstallPanelTask
{
	
	var $domain = 'circulars';
	
	var	$menus = array(
			array(
				'Menu' => array(
					'title' => 'circulars_panel_1',
					'help' => 'Circulars administration'
					),
				'MenuItem' => array(
					array(
						'label' => 'Create a new circular',
						'url' => '/circulars/circulars/add',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Manage circulars',
						'url' => '/circulars/circulars/index',
						'order' => 20,
						'access' => 2
						)		
					)
				),
			array(
				'Menu' => array(
					'title' => 'circulars_panel_2',
					'help' => 'Events administration'
					),
				'MenuItem' => array(
					array(
						'label' => 'Create a new event',
						'url' => '/circulars/events/add',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Manage events',
						'url' => '/circulars/events/index',
						'order' => 20,
						'access' => 2
						)		
					)
				),
			array(
				'Menu' => array(
					'title' => 'circulars_panel_3',
					'help' => 'Circular complements'
					),
				'MenuItem' => array(
					array(
						'label' => 'Types',
						'url' => '/circulars/circular_types/index',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Response Boxes',
						'url' => '/circulars/circular_boxes/index',
						'order' => 20,
						'access' => 2
						),
					array(
						'label' => 'Addressees',
						'url' => '/circulars/addressees/index',
						'order' => 30,
						'access' => 2
						),
							
					)
				)
		
		);
	
}

?>
