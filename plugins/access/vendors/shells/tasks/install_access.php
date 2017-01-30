<?php

App::import('Vendor', 'AppShell');
App::import('Model', 'Access.Role');
App::import('Model', 'Access.User');
App::import('Core', 'Security');

class InstallAccessTask extends AppShell
{
	
	function execute() {
		$this->out('Installing Access System');
		$this->hr();
		$path = APP.'config'.DS.'access.php';
		if (!file_exists($path)) {
			$this->error(sprintf('Missing %s file.', $path));
		}
		include_once($path);
		$this->batchCreateRoles($roles);
		$this->createUsers($users);
	}
	
	public function createUsers($users)
	{
		$this->out('Creating Users.');
		$this->out();
		
		$User = ClassRegistry::init('User');
		$Role = ClassRegistry::init('Role');
		
		foreach ($users as $username => $data) {
			if ($User->isRegistered($data['username'])) {
				$this->out(sprintf('Skipping %s existing user.', $data['username']));
				continue;
			}
			$registration = array(
				'User' => array(
					'username' => $data['username'],
					'realname' => $data['realname'],
					'email' => $data['email'],
					'confirm_email' => $data['email'],
					'password' => Security::hash($data['password'], 'sha1', true),
					'confirm_password' => $data['password'],
					'active' => 1
				)
			);
			$this->out(sprintf('Creating %s user.', $data['username']));
			$User->add($registration);
			$Role->getByName($data['role']);
			$this->out(sprintf('Attaching user %s to role %s', $data['username'], $Role->getName()));
			$User->attach($Role);
		}
	}
	
	public function batchCreateRoles($roles) 
	{
		$this->out('Creating Roles.');
		$this->out();
		
		$Role = ClassRegistry::init('Role');
		$countRoles = $created = 0;
		
		foreach ($roles as $role => $patterns) {
			$this->out(sprintf('%s role.', $role));
			$countRoles++;
			if (!$Role->getByName($role)) {
				$roleDescription = sprintf('%s role automatically created.', $role);
				$Role->add($role, $roleDescription);
				$this->out(sprintf('Role %s doesn\'t exist. Creating role.', $role));
				$created++;
			}
			
			$this->out(sprintf('Preparing to add permissions for %s role.', $role));
			$this->batchPermissions($Role, $patterns);
		}
		$this->hr();
		$this->out('Task Ended.');
		$this->out(sprintf('%s roles considered. Created: %s. Existing: %s.', $countRoles, $created, $countRoles-$created));
	}
	
	private function batchPermissions(Role $Role, $patterns) {
	
		if (!is_array($patterns)) {
			$patterns = array($patterns => true);
		}
		$Permission = ClassRegistry::init('Permission');

		foreach ($patterns as $pattern => $access) {
			if (substr($pattern, 0, 1) !== '/') {
				continue;
			}
			$this->out(sprintf('Permission to access %s.', $pattern));
			$Permission->getByPattern($pattern);
			if ($Permission->null()) {
				$this->out(sprintf('Permission doesn\'t exist. New permission for pattern %s.', $pattern));
				$template = $access ? 'Allow %s' : 'Forbid %s';
				$Permission->add($pattern, sprintf($template, $pattern));
			}
			if ($access) {
				$this->out(sprintf('Role %s is allowed to access %s.', $Role->getName(), $pattern));
				$Role->allow($Permission);
			} else {
				$this->out(sprintf('Role %s is denied to access %s.', $Role->getName(), $pattern));
				$Role->deny($Permission);
			}
		}
	}
	
	
	
	
	
}

?>