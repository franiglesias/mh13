<?php

/**
* 
*/
class FiFolder
{
	private $path;
	
	function __construct($path)
	{
		try {
			$this->existsCheck($path);
			$this->writableCheck($path);
			$this->path = $path;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function get()
	{
		return $this->path;
	}
	
	private function existsCheck($path)
	{
		if (!file_exists($path)) {
			throw new RuntimeException(sprintf("Folder %s doesn't exists.", $path));
		}
	}
	
	private function writableCheck($path)
	{
		if (!is_writable($path)) {
			throw new RuntimeException(sprintf("Can\'t write in directory %s.", $path));
		}
	}
}


?>