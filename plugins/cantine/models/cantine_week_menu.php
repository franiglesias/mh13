<?php
class CantineWeekMenu extends CantineAppModel {
	var $name = 'CantineWeekMenu';
	var $displayField = 'title';

	var $hasMany = array(
		'CantineDayMenu' => array(
			'className' => 'Cantine.CantineDayMenu',
			'foreignKey' => 'cantine_week_menu_id',
			'dependent' => false,
		),
		'CantineMenuDate' => array(
			'className' => 'Cantine.CantineMenuDate',
			'foreignKey' => 'cantine_week_menu_id',
			'dependent' => false,
		)
	);

}
?>