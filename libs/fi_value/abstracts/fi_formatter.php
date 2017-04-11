<?php

App::import('Lib', 'fi_value/abstracts/FiValueDecorator');

abstract class FiFormatter extends FiValueDecorator
{
	/**
	 * format parameters
	 *
	 * @var mixed
	 */
	protected $_format = '';

	function __construct(FiValue $Value, $format = null)
	{
		$this->_Value = $Value;
		if (!is_null($format)) {
			$this->_format = $format;
		}
	}

    /**
	 * Returns the formatted value
	 *
	 * @return mixed
	 * @author Fran Iglesias
	 */
	public function get()
	{
		return $this->format();
	}

    /**
     * Must override in subclasses
     * Used data in $_format to
     *
     * @return void
     * @author Fran Iglesias
     */
    abstract function format();
	
	/**
	 * Sets a value in the decorated class, even after a chain of formats
	 *
     * @param string $value
     *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function set($value)
	{
		$this->_Value->set($value);
	}
	
	/**
	 * Retrieves the value of the decorated base class, even in a chain of formatters
	 *
	 * @return mixed original value
	 * @author Fran Iglesias
	 */
	protected function original()
	{
		if (property_exists($this->_Value, '_value')) {
			return $this->_Value->get();
		}
		return $this->_Value->original();
	}
	
}

?>
