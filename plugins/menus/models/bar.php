<?php
class Bar extends MenusAppModel {
	var $name = 'Bar';
	var $displayField = 'title';

	var $hasMany = array(
		'Menu' => array(
			'className' => 'Menus.Menu',
			'foreignKey' => 'bar_id',
			'dependent' => false,
			'order' => array('Menu.order' => 'asc'),
		)
	);
	
	var $validate = array(
		'title' => 'notEmpty'
	);

	// public function  __construct($id = false, $table = null, $ds = null) {
	// 	parent::__construct($id, $table, $ds);
	// }

	public function getByTitle($title, $user = false)
	{
		return $this->get($this->field('id', array('title' => $title)), $user);
	}

	public function get($id, $user = false)
	{
		try {
			$this->setId($id);
			$this->read(null);
			$theBar = array();
			$menus = $this->Menu->findAvailable($this->id, $user);
			foreach ($menus as $menu) {
				$theBar[] = $this->Menu->get($menu, $user);
			}
			return $theBar;
		} catch (Exception $e) {
			return false;
		}
	}
	
}
?>