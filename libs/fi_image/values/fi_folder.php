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
			$this->createIfDoesNotExist($path);
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
	
	private function createIfDoesNotExist($path)
	{
		if (file_exists($path)) {
			return;
		}
		if (!mkdir($path, 0777, true)) {
			throw new RuntimeException(sprintf("Can\'t create the needed directory %s.", $path));
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