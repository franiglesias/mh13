<?php
class CantineGroup extends CantineAppModel {
	var $name = 'CantineGroup';
	var $displayField = 'title';
	
	var $hasMany = array(
		'Section' => array(
			'className' => 'School.Section'
		),
		'CantineRule' => array(
			'className' => 'Cantine.CantineRule'
		)
	);
	
	private function getRules()
	{
		return Set::extract('/CantineRule/.', $this->CantineRule->find('all', array(
			'conditions' => array(
				'cantine_group_id' => $this->id
			),
			'order' => array(
				'cantine_turn_id' => 'asc'
			)
		)));
	}
	
	public function retrieve($id = null)
	{
		$this->setId($id);
		$this->read(null);
		$this->data['CantineRule'] = $this->getRules($id);
	}
}
?>