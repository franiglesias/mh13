<?php

App::import('Model', 'Access.PermissionsRole');
App::import('Model', 'Access.Permission');

class Role extends AccessAppModel {

	var $name = 'Role';
	var $displayField = 'role';
	
	/**
	 * Creates a new Role with a $name and a $description
	 *
     * @param string $name
     * @param string $description
     *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function add($name, $description)
	{
		$this->create();
		$this->set(array(
			'role' => $name,
			'description' => $description
		));
		return $this->save();
	}
	
	/**
	 * Creates an empty role and assigns an ID
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function init()
	{
		$this->create();
		$this->save(array(
			'role' => false,
			'description' => false
		), false);
	}

	/**
	 * Loads a Role object with data looking for name/alias of the role
	 *
     * @param string $name
     *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function getByName($name)
	{
		$this->data = $this->findByRole($name);
		if (!$this->data) {
			return false;
		}
		$this->id = $this->data['Role']['id'];
		return true;
	}
	
	/**
	 * Loads a Role by its Id
	 *
     * @param string $id
     *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function get($id)
	{
		$this->load($id);
	}
	
	/**
	 * Returns the name of the role
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function getName()
	{
		return $this->data['Role']['role'];
	}
	
	/**
	 * Assocs a Permission with current Role
	 *
	 * @param Permission $Permission 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function allow(Permission $Permission)
	{
		ClassRegistry::init('PermissionsRole')->allow($Permission, $this);
	}
	
	/**
	 * Assocs a Permission with current role
	 *
	 * @param Permission $Permission 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function deny(Permission $Permission)
	{
		ClassRegistry::init('PermissionsRole')->deny($Permission, $this);
	}
	

}
?>
