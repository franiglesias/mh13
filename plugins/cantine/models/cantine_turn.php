<?php
class CantineTurn extends CantineAppModel {
	var $name = 'CantineTurn';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'CantineRule' => array(
			'className' => 'Cantine.CantineRule',
			'foreignKey' => 'cantine_turn_id',
			'dependent' => false,
		)
	);
	
}
?>