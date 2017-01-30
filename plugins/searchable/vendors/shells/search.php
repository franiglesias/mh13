<?php
App::import('Vendor', 'AppShell');
/**
* 
*/
class SearchShell extends AppShell
{
	var $tasks = array('Rebuild');
	
	function main()
	{
		$this->hr();
		$this->out('Searchable Utilities');
		$this->hr();
		$this->help();
	}
	
	public function help()
	{
		$this->out('Usage:');
		$this->out();
		$this->out('Rebuild Search Index: cake search rebuild');
		$this->hr();
	}
}



?>