<?php
class Technician extends ItAppModel {
	var $name = 'Technician';
	var $displayField = 'title';
	var $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Maintenance' => array(
			'className' => 'Maintenance',
			'foreignKey' => 'technician_id',
			'dependent' => false,
		)
	);

}
