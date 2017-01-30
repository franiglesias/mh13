<?php
class Stage extends SchoolAppModel {
	
	const CONFIG = 'School.roles.coordinator';
	var $name = 'Stage';
	var $displayField = 'title';
	
	var $hasMany = array(
		'Section' => array(
			'className' => 'School.Section',
			'foreignKey' => 'stage_id',
			'dependent' => false,
		)
	);
	
	var $belongsTo = array(
		'Coordinator' => array(
			'className' => 'Access.User',
			'foreignKey' => 'coordinator_id',
		)
	);
	
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
