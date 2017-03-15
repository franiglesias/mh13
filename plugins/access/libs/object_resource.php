<?php


class ObjectResource implements AccessResource
{
	
	private $class;
	private $id;
	
	function __construct($Object)
	{
		$this->class = get_class($Object);
		$this->id = $Object->getID();
	}
	
	public function value()
	{
		return '/#'.$this->class.'#'.$this->id;
	}
	
	public function pattern()
	{
		return '/#'.$this->class.'#';
	}
}
	
?>