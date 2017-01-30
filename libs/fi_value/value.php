<?php

App::import('Lib', 'fi_value/interfaces/FiValue');
/**
 * Value contents a value of any type (at the moment)
 *
 * @package default
 * @author Fran Iglesias
 */
class Value	implements FiValue
{
	/**
	 * The value
	 *
	 * @var mixed
	 */
	var $_value = null;
	
	/**
	 * Set value on instantiation
	 *
	 * @param mixed $value 
	 */
	function __construct($value = null)
	{
		$this->_value = $value;
	}
	
	public function get()
	{
		return $this->_value;
	}
	public function set($value)
	{
		$this->_value = $value;
	}
}


?>