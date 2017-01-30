<?php
class CantineDayMenu extends CantineAppModel {
	var $name = 'CantineDayMenu';

	var $belongsTo = array(
		'CantineWeekMenu' => array(
			'className' => 'CantineWeekMenu',
			'foreignKey' => 'cantine_week_menu_id',
		)
	);
}
?>