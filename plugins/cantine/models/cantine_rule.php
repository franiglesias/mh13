<?php
class CantineRule extends CantineAppModel {
	var $name = 'CantineRule';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'CantineTurn' => array(
			'className' => 'Cantine.CantineTurn',
			'foreignKey' => 'cantine_turn_id',
		),
		'Section' => array(
			'className' => 'School.Section',
			'foreignKey' => 'section_id',
		),
		'CantineGroup' => array(
			'className' => 'Cantine.CantineGroup',
		)
	);
	
	var $actsAs = array(
		'Ui.Binary' => array(
			'day_of_week'
		)
	);
	
	var $states = array(
		0 => 'Ignore',
		1 => 'No',
		2 => 'Yes'
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->states = array(
			0 => __d('cantine', 'Ignore', true),
			1 => __d('cantine', 'No', true),
			2 => __d('cantine', 'Yes', true)
		);
	}


}
?>