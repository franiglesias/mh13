<?php
class MeritType extends ResumesAppModel {
	var $name = 'MeritType';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Merit' => array(
			'className' => 'Merit',
			'foreignKey' => 'merit_type_id',
			'dependent' => false,
		)
	);
	
}
?>