<?php

App::import('vendor', 'AppShell');

/**
* 
*/
class MhcleanShell extends AppShell
{
	var $tasks = array('Cache', 'Tags', 'Thumbs', 'Logs');
	
	function main()
	{
		$this->help();
	}
	
	
	public function help()
	{
		$this->out('Mhclean Utility');
		$this->hr();
		$this->out('     Reset cache:          cake mhclean cache',2);
		$this->out('     Remove unused tags:   cake mhclean tags',2);
		$this->out('     Clean thumbs folders: cake mhclean thumbs',2);
		$this->out('     Clean logs folder:    cake mhclean logs',2);
		$this->out('     Clean all:            cake mhclean all');
		$this->out();
		$this->out('     Params  dry: don\'t delete');
		$this->hr();
	}

/**
 * Run all tasks
 *
 * @return void
 */	
	public function all()
	{
		$this->Cache->execute();
		$this->Thumbs->execute();
		$this->Logs->execute();
		$this->Tags->execute();
	}
}


?>