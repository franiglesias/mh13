<?php
/* Prize Fixture generated on: 
Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'Europe/Berlin' for 'CEST/2.0/DST' instead in /Library/WebServer/Documents/mh13/vendors/shells/templates/milhojas/classes/fixture.ctp on line 24
2013-05-23 09:05:43 : 1369294783 */
class PrizeFixture extends CakeTestFixture {
	var $name = 'Prize';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'number' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 250, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sponsor' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 250, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'special' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'number' => 1,
			'title' => 'Lorem ipsum dolor sit amet',
			'sponsor' => 'Lorem ipsum',
			'special' => 0
		),
		array(
			'id' => 2,
			'number' => null,
			'title' => 'Lorem ipsum dolor 2',
			'sponsor' => 'Lorem ipsum',
			'special' => 0
		),
		array(
			'id' => 3,
			'number' => null,
			'title' => 'Lorem ipsum dolor sit amet 3',
			'sponsor' => 'Dolor sit',
			'special' => 1
		),
		
		
	);
}
?>
