<?php

App::import('Lib', 'fi_values/fs/FiFolder');

class FiFileSystemService
{
	
	function __construct()
	{
		# code...
	}
	
	public function getFolder($path)
	{
		return new FiFolder($path);
	}
	
	public function createFolder($path)
	{
		if (!@mkdir($path, 0755, true)) {
			throw new RuntimeException(sprintf("Can\'t create the needed directory %s.", $path));
		}
		return new FiFolder($path);
	}
	
	
	
}
?>