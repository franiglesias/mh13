<?php


/**
 * FiValue class have a get method to return the value they store
 *
 * @package default
 * @author Fran Iglesias
 */
interface FiValue {
	/**
	 * Returns the value
	 *
	 * @return mixed Stored value
	 */
	public function get();
	public function set($value);
}


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

/**
 * Decorator for FiValue classes.
 *
 * @package default
 * @author Fran Iglesias
 */
abstract class ValueDecorator implements FiValue
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