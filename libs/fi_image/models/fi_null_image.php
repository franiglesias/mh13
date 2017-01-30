<?php

App::import('Lib', 'fi_image/models/FiImage');
/**
* 
*/
class FiNullImage extends FiImage
{

	public function __construct()
	{
	}

	public function read()
	{
	}
	
	public function write()
	{
	}
	
	public function getType()
	{
		return null;
	}
}


?>