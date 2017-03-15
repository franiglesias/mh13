<?php

App::import('Model', 'Access.Permission');
App::import('Model', 'Access.Role');
App::import('Model', 'Access.User');


class AuthorizableBehavior extends ModelBehavior {

	var $settings = array();
	var $ResourceFactory;
	
	function setup(&$model, $config = array()) {
		$this->ResourceFactory = new ResourceFactory();
	}
	
	public function makePrivate(&$model, $roleIds)
	{
		$Token = $this->getResource($model);
		$Permission = ClassRegistry::init('Permission');
		$Role = ClassRegistry::init('Role');

        $Permission->getByPattern($Token->value());
		if ($Permission->null()) {
			$Permission->add($Token->value(), 'Access to');
		}
		$Permission->flush();

        foreach ($roleIds as $roleId) {
			$Role->get($roleId);
			$Role->allow($Permission);
		}
	}

    private function getResource($model)
    {
        return $this->ResourceFactory->make($model);
    }
	
	public function makePublic(&$model)
	{
		$Token = $this->getResource($model);
		$Permission = ClassRegistry::init('Permission');
		$Permission->getByPattern($Token->value());
		if ($Permission->null()) {
			return false;
		}
		$Permission->flush();
	}
	
	public function getPrivate(&$model, User $User)
	{
		$Token = $this->getResource($model);
		$fields = array('Permission.url_pattern');
		$joins = array(
			array(
				'table' => 'roles_users',
				'alias' => 'RolesUser',
				'type' => 'left',
				'conditions' => array('RolesUser.user_id = User.id')
			),
			array(
				'table' => 'permissions_roles',
				'alias' => 'PermissionsRole',
				'type' => 'left',
				'conditions' => array(
					'RolesUser.role_id = PermissionsRole.role_id',
					'PermissionsRole.access' => 1
				)
			),
			array(
				'table' => 'permissions',
				'alias' => 'Permission',
				'type' => 'left',
				'conditions' => array('PermissionsRole.permission_id = Permission.id')
			)	
		);
		$conditions = array(
			'User.username' => $User->getName(),
			'Permission.url_pattern LIKE "'.$Token->pattern().'%"'
		);
		$permissions = $User->find('all',compact('fields', 'joins', 'conditions'));
		return str_replace($Token->pattern(), '', Set::extract('/Permission/url_pattern', $permissions));
	}
}

?>