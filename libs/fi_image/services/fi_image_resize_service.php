<?php

class FiImageResizeService
{
	private $Original;
	private $Target;
	
	function __construct(FiImageSize $Original, FiImageSize $Target)
	{
		$this->Original = $Original;
		$this->Target = $Target;
	}
	
	public function fit()
	{
		$deltaX = $this->Target->width() / $this->Original->width();
		$deltaY = $this->Target->height() / $this->Original->height();
		if ($deltaX > $deltaY) {
			$deltaX = $deltaY;
		} else {
			$deltaY = $deltaX;
		}
		return new FiImageSize($deltaX*$this->Original->width(), $deltaY*$this->Original->height());
	}
	
	public function fill()
	{
		$deltaX = $this->Target->width() / $this->Original->width();
		$deltaY = $this->Target->height() / $this->Original->height();
		
		if ($deltaX < $deltaY) {
			$deltaX = $deltaY;
		} else {
			$deltaY = $deltaX;
		}
		
		return new FiImageSize($deltaX*$this->Original->width(), $deltaY*$this->Original->height());
	}
}


?>