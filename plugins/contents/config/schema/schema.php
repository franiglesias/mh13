<?php 
/* contents schema generated on: 2013-02-22 13:40:49 : 1361536849*/
class contentsSchema extends CakeSchema {
	var $name = 'contents';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $channels = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'license_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'pubDate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'icon' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'image' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'theme_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'theme' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'default_comments' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 2),
		'twitter_account' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'twitter_password' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'menu_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'layout' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_layout' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_template' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'guest' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'guestpwd' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $i18n = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'locale' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'field' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'locale' => array('column' => 'locale', 'unique' => 0), 'model' => array('column' => 'model', 'unique' => 0), 'row_id' => array('column' => 'foreign_key', 'unique' => 0), 'field' => array('column' => 'field', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $items = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'parent_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'image' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'enclosure_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'pubDate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'expiration' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'license_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'channel_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'featured' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'stick' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'remarks' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'live' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'allow_comments' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'search_if_expired' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'readings' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'guest' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'guestpwd' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $legacies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $sites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'theme_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'layout' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'theme' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $static_i18ns = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'locale' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'field' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'locale' => array('column' => 'locale', 'unique' => 0), 'model' => array('column' => 'model', 'unique' => 0), 'row_id' => array('column' => 'foreign_key', 'unique' => 0), 'field' => array('column' => 'field', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $static_pages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'readings' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'image' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'order' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $tagged = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tag_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'language' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'UNIQUE_TAGGING' => array('column' => array('model', 'foreign_key', 'tag_id', 'language'), 'unique' => 1), 'INDEX_TAGGED' => array('column' => 'model', 'unique' => 0), 'INDEX_LANGUAGE' => array('column' => 'language', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $themes = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'theme' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
}
?>