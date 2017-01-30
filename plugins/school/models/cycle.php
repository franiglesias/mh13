<?php
class Cycle extends SchoolAppModel {
	const CONFIG = 'School.roles.coordinator';
	var $name = 'Cycle';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Section' => array(
			'className' => 'School.Section',
			'foreignKey' => 'cycle_id',
			'dependent' => false,
		)
	);

	var $belongsTo = array(
		'Coordinator' => array(
			'className' => 'Access.User',
			'foreignKey' => 'coordinator_id',
		)
	);
	
	public function coordinators()
	{
		$role = Configure::read('School.roles.coordinator');
		$coordinators = $this->Coordinator->find('role', $role);
		return $coordinators;
	}

	public function findCoordinators()
	{
		$all = $this->Coordinator->listWithRole($this->getCoordinatorRole());
		if (!$all) {
			throw new ConfigureException('There are no users with '.Configure::read(self::CONFIG).' role.', 1);
		}
		return $all;
	}
	
	
	private function getCoordinatorRole()
	{
		$this->Coordinator->Role->getByName(Configure::read(self::CONFIG));
		if ($this->Coordinator->Role->null()) {
			throw new ConfigureException('There is no Role defined in '.self::CONFIG.'.', 1);
		}
		return $this->Coordinator->Role;
	}


}
?>