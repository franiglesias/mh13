<?php

App::import('Lib', 'data_provider/abstracts/AbstractDataProvider');
App::import('Lib', 'data_provider/interfaces/PlainDataProvider');
App::import('Lib', 'data_provider/interfaces/MultiDataProvider');

class NullDataProvider extends AbstractDataProvider implements PlainDataProvider, MultiDataProvider
{
	
	function __construct() 
	{
		$this->_source = null;
	}
	
	public function bind(&$var)
	{
	}
	
	public function hasField($field)
	{
		return null;
	}
	
	public function value($field)
	{
		return null;
	}
	
	public function attach(SingleDataProvider &$Single) {
		
	}
	
	# Iterator delegation functions
	
	public function rewind() {}
	public function next() {}
	public function hasNext() {return false;}
	public function &current() {return $this->_source;}
	public function pointer($newPointer = null) {return null;}
	public function count() {return false;}
}


?>