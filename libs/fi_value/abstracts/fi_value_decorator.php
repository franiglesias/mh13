<?php

App::import('Lib', 'fi_value/interfaces/FiValue');
/**
 * Decorator for FiValue classes.
 *
 * @package default
 * @author Fran Iglesias
 */
abstract class FiValueDecorator implements FiValue
{
	var $_Value = null;

	function __construct(Value $Value)
	{
		$this->_Value = $_Value;
	}
	
	public function get()
	{
		return $this->_Value->get();
	}
	
	public function set($value)
	{
		$this->_Value->set($value);
	}
}


?>