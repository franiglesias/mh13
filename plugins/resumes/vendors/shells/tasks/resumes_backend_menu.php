<?php

App::import('Vendor', 'InstallMenuAtBackendTask');

class ResumesBackendMenuTask extends InstallMenuAtBackendTask
{
	var	$menus = array(
		array(
			'Menu' => array(
				'title' => 'resumes_admin',
				'help' => 'Resumes management',
				'order' => 60,
				'label' => 'CV'
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
					'label' => '/',
					'order' => 100,
					'access' => 0
				),
				array(
					'label' => 'Manage Categories',
					'url' => '/resumes/merit_types/index',
					'help' => 'Manage Merit Types Categories',
					'order' => 130,
					'access' => 2
					),
				array(
					'label' => 'Manage Positions',
					'url' => '/resumes/positions/index',
					'help' => 'Manage Positions',
					'order' => 140,
					'access' => 2
					)
				
				)
			),
		);
	
}

?>
