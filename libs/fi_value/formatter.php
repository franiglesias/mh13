<?php

App::import('Lib', 'FiValue');
/**
 * Abstract class for Formatters
 *
 * @package default
 * @author Fran Iglesias
 */
abstract class FiFormatter extends ValueDecorator
{
	/**
	 * format parameters
	 *
	 * @var mixed
	 */
	protected $_format = '';
	/**
	 * Must override in subclasses
	 * Used data in $_format to 
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	abstract function format();
	
	function __construct(FiValue $Value, $format = '')
	{
		$this->_Value = $Value;
		if ($format) {
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
	 * Sets a value in the decorated class, even after a chain of formats
	 *
	 * @param string $value 
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

App::import('Lib', 'Singleton');
/**
* Short of Formatter factory
*/
class Formatter extends Singleton
{
	public static function apply(FiValue $V, $type, $format = false)
	{
		if (is_array($type)) {
			$format = $type;
			$type = 'multi';
		}
		
		if ($type == 'multi') {
			$formatters = $format;
		} else {
			$formatters = array($type => $format);
		}
		foreach ($formatters as $format => $options) {
			if (!is_string($format)) {
				$format = key($options);
				$options = $options[$format];
			}
			$Formatter = ucfirst($format).'Formatter';
			App::import('Lib', 'fi_value/formatters/'.$Formatter);
			if (!class_exists($Formatter)) {
				continue;
				// throw new RunTimeException(sprintf('%s class doesn\'t exist.', $Formatter));
			}	
			if ($options) {
				$V = new $Formatter($V, $options);
			} else {
				$V = new $Formatter($V);
			}
		}
		return $V;
	}
	
	public static function get(FiValue $V, $type, $format = false)
	{
		$Formatter = ucfirst($type).'Formatter';
		App::import('Lib', 'fi_value/formatters/'.$Formatter);
		if (!class_exists($Formatter)) {
			throw new RunTimeException(sprintf('%s class doesn\'t exist.', $Formatter));
		}	
		if ($format) {
			$V = new $Formatter($V, $format);
		} else {
			$V = new $Formatter($V);
		}
		return $V;
	}
}

?>