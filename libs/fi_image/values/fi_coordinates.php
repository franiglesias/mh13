<?php

class FiCoordinates
{
	private $x;
	private $y;
	function __construct($x, $y)
	{
		$this->x = $x;
		$this->y = $y;
	}
	
	public function x()
	{
		return $this->x;
	}
	
	public function y()
	{
		return $this->y;
	}
}


?>