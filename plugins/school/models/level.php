<?php
class Level extends SchoolAppModel {
	var $name = 'Level';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Section' => array(
			'className' => 'School.Section',
			'foreignKey' => 'level_id',
			'dependent' => false,
		)
	);

}
?>