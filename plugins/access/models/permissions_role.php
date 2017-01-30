<?php
/**
 * PermissionsRole Model
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
class PermissionsRole extends AccessAppModel {
	var $name = 'PermissionsRole';
	
	var $belongsTo = array(
		'Permission' => array(
			'className' => 'Access.Permission'
		),
		'Role' => array(
			'className' => 'Access.Role'
		)
	);
	
	public function init($roleId)
	{
		$this->create();
		$this->set(array(
			'role_id' => $roleId,
			'access' => false
		));
		$this->save();
		return $this->getLastInsertID();
	}
	
	public function allow(Permission $Permission, Role $Role)
	{
		if (!$this->allowed($Permission, $Role)) {
			return $this->link($Permission, $Role, true);
		}
	}
	
	public function deny(Permission $Permission, Role $Role)
	{
		if (!$this->denied($Permission, $Role)) {
			return $this->link($Permission, $Role, false);
		}
	}
	
	
	public function allowed(Permission $Permission, Role $Role)
	{
		return $this->linked($Permission, $Role, true);
	}
	
	public function denied(Permission $Permission, Role $Role)
	{
		return $this->linked($Permission, $Role, false);
	}
	
	public function link(Permission $Permission, Role $Role, $allowed)
	{
		$this->create();
		$this->set(array(
			'permission_id' => $Permission->getID(),
			'role_id' => $Role->getID(),
			'access' => $allowed
		));
		return $this->save();
	}
	
	public function linked(Permission $Permission, Role $Role, $allowed)
	{
		return $this->find('count', array(
			'conditions' => array(
				'permission_id' => $Permission->getID(),
				'role_id' => $Role->getID(),
				'access' => $allowed
				)
		));
	}

	public function flushPermission(Permission $Permission)
	{
		$this->deleteAll(array(
			'permission_id' => $Permission->getID()
		));
	}
	
	public function flushRole(Role $Role)
	{
		$this->deleteAll(array(
			'role_id' => $Role->getID()
		));
	}
}
?>