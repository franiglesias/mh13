<?php

App::import('Vendor', 'InstallPanelTask');

class ContentsPanelTask extends InstallPanelTask
{
	
	var $domain = 'contents';
	
	var	$menus = array(
			array(
				'Menu' => array(
					'title' => 'contents_panel_1',
					'help' => 'Items creation and management'
					),
				'MenuItem' => array(
					array(
						'label' => 'Items',
						'url' => '/contents/items/index',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Create Item',
						'url' => '/contents/items/add',
						'order' => 20,
						'access' => 2
						)		
					)
				),
			array(
				'Menu' => array(
					'title' => 'contents_panel_2',
					'help' => 'Channels and Static Content Management'
					),
				'MenuItem' => array(
					array(
						'label' => 'Channels',
						'url' => '/contents/channels/index',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Static Pages',
						'url' => '/contents/static_pages/index',
						'order' => 20,
						'access' => 2
						),
					array(
						'label' => 'Image Collections',
						'url' => '/uploads/image_collections/index',
						'order' => 30,
						'access' => 2
						)
					)
				),
			array(
				'Menu' => array(
					'title' => 'contents_panel_3',
					'help' => 'Sites, Comments and Uploads global admin'
					),
				'MenuItem' => array(
					array(
						'label' => 'Sites',
						'url' => '/contents/sites/index',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Comments',
						'url' => '/comments/comments/index',
						'order' => 20,
						'access' => 2
						),
					array(
						'label' => 'Uploads',
						'url' => '/uploads/uploads/index',
						'order' => 30,
						'access' => 2
						)
					)
				),
			array(
				'Menu' => array(
					'title' => 'contents_panel_4',
					'help' => 'Aggregator contents'
					),
				'MenuItem' => array(
					array(
						'label' => 'Feeds',
						'url' => '/aggregator/feeds/index',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Add Feed',
						'url' => '/aggregator/feeds/add',
						'order' => 20,
						'access' => 2
						),
					array(
						'label' => 'Planets',
						'url' => '/aggregator/planets/index',
						'order' => 30,
						'access' => 2
						)
					)
				)			

		);
	
}

?>
