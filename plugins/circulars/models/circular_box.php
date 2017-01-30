<?php
class CircularBox extends CircularsAppModel {
	var $name = 'CircularBox';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Circular' => array(
			'className' => 'Circular',
			'foreignKey' => 'circular_box_id',
			'dependent' => false,
		)
	);

}
?>