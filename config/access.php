<?php
	
# Roles configuration section

	$roles = array(
		# Minimal roles
		
		// Root has full access to actions
		
		'root' => array(
			'/%' => true
		),
		
		// Basic user has access to profile and dashboards
			
		'user' => array(
			'/access/users/profile' => true,		// Access to its own profile
			'/access/users/dashboard' => true,		// Access to the dashboard and dashboard panels
			'%_dashboard' => true,
			'/access/users/logout'
		),
			
		# Roles for contents plugin
		
		'blogger' => array(
			'/contents/items/%' => true,			// Access to manage items
			'/contents/contents/index' => true,		// Access to contents panel
		),
		'blogmaster' => array(
			'/contents/channels/%' => true			// Access to manage channels
		),
			
		'circulars' => array(
			'//circulars/supervision' => true,
			'/circulars/circulars/%' => true
		)
	);

# Users configuration section

	$users = array(
		'root' => array(
			'username' => 'root',
			'realname' => 'Site Super User',
			'email' => 'frankie@miralba.org',
			'password' => 'root',
			'role' => 'root'
		),
		'user' => array(
			'username' => 'user',
			'realname' => 'Site Basic User',
			'email' => 'frankie@miralba.org',
			'password' => 'user',
			'role' => 'user'
		)
	);

?>