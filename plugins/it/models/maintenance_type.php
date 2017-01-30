<?php
class MaintenanceType extends ItAppModel {
	var $name = 'MaintenanceType';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Maintenance' => array(
			'className' => 'Maintenance',
			'foreignKey' => 'maintenance_type_id',
			'dependent' => false,
		)
	);

}
?>