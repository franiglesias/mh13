<?php

App::import('Lib', 'fi_image/values/FiImageCanvas');
App::import('Lib', 'fi_image/values/FiImageColor');

class FiImageNullCanvas extends FiImageCanvas
{
	public function __construct()
	{
	}
	
	public function get()
	{
		return null;
	}
	
	public function size()
	{
		return null;
	}
}
?>