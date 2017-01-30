<?php

class GApps extends GdataAppModel {

	var $name ='GApps';
	var $useTable = false;
	var $useDbConfig = 'gapps';

/**
* Imports the datasources from the plugin and adds to the connection manager
*/
	public function __construct() {
		App::import(array('type' => 'File', 'name' => 'Gdata.GDATA_CONFIG', 'file' => 'config'.DS.'gdata_config.php'));
		App::import(array('type' => 'File', 'name' => 'Gdata.GdataSource', 'file' => 'models'.DS.'datasources'.DS.'gdata_source.php'));
		App::import(array('type' => 'File', 'name' => 'Gdata.GdataGapps', 'file' => 'models'.DS.'datasources'.DS.'gdata'.DS.'gdata_gapps.php'));
		$config =& new GDATA_CONFIG();
		ConnectionManager::create('gapps', $config->gapps);
		parent::__construct();
	}
	
	public function login($email, $password) {
		$ds =& ConnectionManager::getDataSource('gapps');
		$ds->setLogin($email, $password);
		$result = $ds->connect();
		return $result;
	}
}
?>
