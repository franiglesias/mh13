<?php

/**
* Implementes DataProvider Interface
*
* Binds a view Var that is a dictionary array (key => value)
*/
App::import('Lib', 'data_provider/abstracts/SingleDataProvider');

class ArrayDataProvider extends SingleDataProvider {
	
	public function hasField($field)
	{
		if (!$this->bound()) {
			return false;
		}
		return array_key_exists($field, $this->_source);
	}
	
	public function hasKey($key)
	{
		return $this->hasField($key);
	}
	
	public function value($field)
	{
		if (!$this->hasField($field)) {
			return false;
		}
		return $this->_source[$field];
	}
	
}


?>
