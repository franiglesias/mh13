<?php

/**
* 
*/
class FiImageSize
{
	private $width;
	private $height;
	
	function __construct($width, $height)
	{
		$this->width = $width;
		$this->height = $height;
	}
	
	public function width()
	{
		return $this->width;
	}
	
	public function height()
	{
		return $this->height;
	}
	
	public function fill(FiImageSize $Target)
	{
		$deltaX = $Target->width() / $this->width;
		$deltaY = $Target->height() / $this->height;
		
		if ($deltaX < $deltaY) {
			$deltaX = $deltaY;
		} else {
			$deltaY = $deltaX;
		}
		
		return new FiImageSize($deltaX*$this->width, $deltaY*$this->height);
	}
	
	public function fit(FiImageSize $Target)
	{
		$deltaX = $Target->width() / $this->width;
		$deltaY = $Target->height() / $this->height;
		if ($deltaX > $deltaY) {
			$deltaX = $deltaY;
		} else {
			$deltaY = $deltaX;
		}
		return new FiImageSize($deltaX*$this->width, $deltaY*$this->height);
	}
	
}



?>