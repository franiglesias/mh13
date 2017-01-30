<?php
class Section extends SchoolAppModel {
	const CONFIG = 'School.roles.tutor';
	var $name = 'Section';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Student' => array(
			'className' => 'School.Student',
			'foreignKey' => 'section_id',
			'dependent' => false,
		)
	);
	
	var $belongsTo = array(
		'CantineGroup' => array(
			'className' => 'Cantine.CantineGroup'
		),
		'Cycle' => array(
			'className' => 'School.Cycle'
		),
		'Level' => array(
			'className' => 'School.Level'
		),
		'Stage' => array(
			'className' => 'School.Stage'
		),
		'Tutor' => array(
			'className' => 'Access.User',
			'foreignKey' => 'tutor_id'
		)
	);
	
	
	public function findTutors($returnAvailableOnly = false)
	{
		$all = $this->Tutor->listWithRole($this->getTutorRole());
		if (!$all) {
			throw new ConfigureException(sprintf('There are no users with %s role.', Configure::read(self::CONFIG)), 1);
		}
		if ($returnAvailableOnly) {
			return array_diff_key($all, $this->assignedTutors());
		}
		return $all;
	}
	
	private function getTutorRole()
	{
		$this->Tutor->Role->getByName(Configure::read(self::CONFIG));
		if ($this->Tutor->Role->null()) {
			throw new ConfigureException(sprintf('There is no Role defined in %s.', self::CONFIG), 1);
		}
		return $this->Tutor->Role;
	}
	
	private function assignedTutors()
	{
		$results = $this->find('all', array(
			'fields' => array('tutor_id'),
			'conditions' => array(
				'tutor_id !=' => null
			)
		));
		return Set::combine($results, '/Section/tutor_id', '/Section/tutor_id');
	}
	

}
?>