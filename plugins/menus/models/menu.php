<?php
class Menu extends MenusAppModel {
	var $name = 'Menu';
	var $displayField = 'title';
	
	var $hasMany = array(
		'MenuItem' => array(
			'className' => 'Menus.MenuItem',
			'foreignKey' => 'menu_id',
			'dependent' => true, // Delete Menu, deletes menu_items related
			'order' => array('MenuItem.order' => 'asc')
		)
	);
	
	var $belongsTo = array(
		'Bar' => array(
			'className' => 'Menus.Bar',
			'foreignKey' => 'bar_id',
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

/**
 * Suggest a position in the bar for a new menu. Adds 10 to the max order
 *
 * @param string $bar_id
 *
 * @return integer
 */
	public function newPosition($bar_id)
	{
		$result = $this->find('all', array(
			'fields' => array(
				'MAX(Menu.order) AS max'
			),
			'conditions' => array(
				'Menu.bar_id' => $bar_id
			)
		));
		return $result[0][0]['max'] + 10;
	}

/**
 * Returns a list of menus not associated with a menu bar
 *
 * @return void
 * @author Fran Iglesias
 */
	public function withoutBar()
	{
		$menus = $this->find('list', array(
			'conditions' => array(
				'Menu.bar_id' => null
			)
		));
		return $menus;
	}
	
	public function removeFromBar($id = null)
	{
		$this->setId($id);
		$bar_id = $this->field('bar_id');
		$this->set(array(
		    'bar_id' => null,
		    'order' => null
		));
		$this->save();
		return $bar_id;
	}
	
	
	public function findAvailable($barId, $user)
	{
		if (!$user) {
			return $this->findPublic($barId);
		}
		$menus =  $this->find('all', array(
			'joins' => array(
				$this->joinPermissionForUrl(),
				$this->joinPermissionsRole(),
				$this->joinUser($user)
				),
			'conditions' => $this->buildConditions($barId),
			'order' => $this->order()
		));
		return Set::extract('/Menu/id', $menus);
	}
	
	private function findPublic($barId)
	{
		$menus = $this->find('all', array(
			'conditions' => array(
				'Menu.bar_id' => $barId,
				'Menu.access' => 0
			),
			'order' => $this->order()
		));
		return Set::extract('/Menu/id', $menus);
	}
	
	private function order()
	{
		return array('Menu.order' => 'asc');
	}
	
	private function joinPermissionForUrl()
	{
		return array(
					'table' => 'permissions',
					'alias' => 'Permission',
					'type' => 'LEFT',
					'conditions' => array(
						'Menu.url LIKE Permission.url_pattern',
						'Menu.access' => 2
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
	
	public function joinUser($user)
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

	private function buildConditions($barId)
	{
		return array(
			'Menu.bar_id' => $barId,
			array(
				'or' => array(
					'Menu.access' => array(0,1),
					$this->explicitAccessToMenu()
					)
            )

		);
	}
	
	private function explicitAccessToMenu()
	{
		return array(
			'Menu.access' => 2,
			'RolesUser.user_id is not null'
		);
	}

    public function getByTitle($title, $user)
    {
        return $this->get($this->field('id', array('title' => $title)), $user);
    }

    public function get($id, $user)
    {
        $this->setId($id);
        $this->read(null);
        $this->data['MenuItem'] = Set::extract(
            '/MenuItem/.',
            $this->MenuItem->findByMenuAndUser($id, $user)
        );

        return $this->data;
    }
	
		
	
}

?>
