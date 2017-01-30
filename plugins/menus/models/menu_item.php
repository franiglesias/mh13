<?php
class MenuItem extends MenusAppModel {
	var $name = 'MenuItem';
	var $displayField = 'label';

	var $belongsTo = array(
		'Menu' => array(
			'className' => 'Menus.Menu',
			'foreignKey' => 'menu_id',
		)
	);

	var $validate = array(
		'title' => 'notEmpty'
	);

	// public function  __construct($id = false, $table = null, $ds = null) {
	// 	parent::__construct($id, $table, $ds);
	// }

	function afterSave($created) {
		$this->_deleteCache('menusmenu');
	}

	function afterDelete() {
		$this->_deleteCache('menusmenu');
	}
	
	public function findByMenuAndUser($menu, $user)
	{
		if (!$user) {
			return $this->findPublic($menu);
		}
		return $this->find('all', array(
			'joins' => array(
				$this->joinPermissionsForUrl(),
				$this->joinPermissionsRole(),
				$this->joinUser($user)
			),
			'conditions' => $this->buildConditions($menu),
			'order' => $this->order()
		));
	}
	
	private function findPublic($menu)
	{
		return $this->find('all', array(
			'conditions' => array(
				'MenuItem.access' => 0,
				'MenuItem.menu_id' => $menu
			),
			'order' => $this->order()
		));
	}
	
	private function order()
	{
		return array('MenuItem.order' => 'asc');
	}
	
	private function joinPermissionsForUrl()
	{
		return array(
			'table' => 'permissions',
			'alias' => 'Permission',
			'type' => 'LEFT',
			'foreignKey' => FALSE,
			'conditions' => array(
				'MenuItem.url LIKE Permission.url_pattern',
				'MenuItem.access' => 2
				)
			);
	}
	
	private function joinPermissionsRole()
	{
		return array(
			'table' => 'permissions_roles',
			'alias' => 'PermissionsRole',
			'type' => 'left',
			'conditions' => array(
				'PermissionsRole.permission_id = Permission.id'
			)
		);
	}
	
	private function joinUser($user)
	{
		return array(
			'table' => 'roles_users',
			'alias' => 'RolesUser',
			'type' => 'LEFT',
			'foreignKey' => FALSE,
			'conditions' => array(
				'RolesUser.role_id = PermissionsRole.role_id',
				'RolesUser.user_id' => $user
				)
			);
	}
	
	private function buildConditions($menu)
	{
		return array(
			'MenuItem.menu_id' => $menu,
			array(
				'or' => array(
					'MenuItem.access' => array(0,1),
					$this->accessWithExplicitPermission()
					)
				)
			);
	}
	
	private function accessWithExplicitPermission()
	{
		return array(
			'MenuItem.access' => 2,
			'RolesUser.user_id is not null'
		);
	}
	
	
}
?>