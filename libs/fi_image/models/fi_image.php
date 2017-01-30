<?php

App::import('Lib', 'fi_image/interfaces/FiImageInterface');

App::import('Lib', 'fi_image/values/FiImageCanvas');

class FiImage implements FiImageInterface
{
	protected $image;
	protected $Size;
	
	function __construct(FiImageCanvas $Canvas)
	{
		$this->image = $Canvas->get();
		$this->Size = $Canvas->size();
	}
	
	public function __destruct() { 
	    if(is_resource($this->image)) { 
	      imagedestroy($this->image); 
	    } 
	  }
	
	protected function readSize()
	{
		return new FiImageSize(imagesx($this->image), imagesy($this->image));
	}
	
	# FiImageInterface Implementation
	
	public function set($newImageResource)
	{
		$this->image = $newImageResource;
		$this->Size = $this->readSize();
	}
	
	public function get()
	{
		return $this->image;
	}

	public function size()
	{
		$this->Size = $this->readSize();
		return $this->Size;
	}
	
	public function apply()
	{
	}

	public function read()
	{
	}

	public function write()
	{
		imagepng($this->image);
	}
	
	public function path()
	{
		return $this->Path;
	}
	
	public function __clone()
	{
		$this->image = null;
		$this->read();
	}
	
	
}

?>