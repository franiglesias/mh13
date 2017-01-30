<?php
/**
 * RolesUser Model
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
class RolesUser extends AccessAppModel {
	var $name = 'RolesUser';
	
	public function attached(User $User, Role $Role)
	{
		return $this->find('count', array(
			'conditions' => array(
				'user_id' => $User->getID(),
				'role_id' => $Role->getID()
			)
		));
	}
	
	public function attach(User $User, Role $Role)
	{
		$this->create();
		$this->set(array(
			'user_id' => $User->getID(),
			'role_id' => $Role->getID()
		));
		$this->save();
	}
	
	public function usersWithRole(Role $Role)
	{
		return $this->find('list', array(
			'fields' => array(
				'User.id',
				'User.realname'
			),
			'conditions' => array(
				'role_id' => $Role->getID()
			),
			'joins' => array(
				$this->joinUsers()
			)
		));
	}
	
	private function joinUsers()
	{
		return array(
			'table' => 'users',
			'alias' => 'User',
			'type' => 'left',
			'conditions' => array(
				'User.id = RolesUser.user_id'
			)
		);
	}
}
?>