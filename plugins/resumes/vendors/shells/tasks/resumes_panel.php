<?php
App::import('Vendor', 'InstallPanelTask');

class ResumesPanelTask extends InstallPanelTask
{

	var $domain = 'resumes';
	var $menus = array(
			array(
				'Menu' => array(
					'title' => 'resumes_panel_1',
					'help' => 'Resumes management'
					),
				'MenuItem' => array(
					array(
						'label' => 'Explore',
						'url' => '/resumes/resumes/index',
						'help' => 'Manage resumes',
						'order' => 10,
						'access' => 2
						),
					array(
						'label' => 'Search',
						'url' => '/resumes/resumes/search',
						'help' => 'Search for resumes using keywords',
						'order' => 20,
						'access' => 2
						),
					array(
						'label' => 'Manage Categories',
						'url' => '/resumes/merit_types/index',
						'help' => 'Manage Merit Types Categories',
						'order' => 30,
						'access' => 2
						)
					)
				),

		);
		
}

?>
