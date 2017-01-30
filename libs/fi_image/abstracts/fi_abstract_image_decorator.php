<?php

App::import('Lib', 'fi_image/interfaces/FiImageInterface');

App::import('Lib', 'fi_image/interfaces/FiFilePathInterface');
App::import('Lib', 'fi_image/values/FiNewFilePath');
App::import('Lib', 'fi_image/values/FiFilePath');

abstract class FiAbstractImageDecorator implements FiImageInterface
{
	protected $Image;
	
	public function size()
	{
		return $this->Image->size();
	}

	public function get()
	{
		return $this->Image->get();
	}

	public function path()
	{
		return $this->Image->path();
	}
	
	public function set($newResource)
	{
		$this->Image->set($newResource);
	}
	
	public function apply()
	{
		$this->Image->apply();
	}
	
	public function read()
	{
		$this->Image->read();
	}
	
	public function write()
	{
		$this->Image->write();
	}
	
	public function __clone()
	{
		$this->Image = clone $this->Image;
	}
	
}

?>