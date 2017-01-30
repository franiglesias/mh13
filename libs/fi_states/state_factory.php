<?php

App::import('Lib', 'fi_states/StateException');

/**
 * Simple State Factory to create State Management Classes in a State Pattern
 * State Factory doesn't manage loading of the classes, and detects if are loaded or not
 *
 * @package default
 * @author Fran Iglesias
 */
class StateFactory
{
	protected static $configuration;
	
/**
 * Relates status value and the class that manages it
 *
 * @param $key (string) A key to group states classes. Recommended: the Model classname
 * @param $value (mixes) The status value
 * @param $class (string) The class name of the State class
 * @return void
 */
	public function set($key, $value, $class)
	{
		if (!class_exists($class)) {
			throw new StateException(sprintf('Class %s not loaded.', $class), 1);
		}
		self::$configuration[$key][$value] = $class;
	}
	
/**
 * Returns a State Class
 *
 * @param string $key The model key
 * @param string $value The status value
 * @return class The class that manages the passed status
 * @author Fran Iglesias
 */
	public function get($key, $value)
	{
		if (!isset(self::$configuration[$key][$value])) {
			throw new InvalidStatusStateException(sprintf('Invalid status (%s).', $value), 1);
		}
		
		return new self::$configuration[$key][$value]();
	}

/**
 * Returns stored configuration
 *
 * @param string $key limit the results to a specific model
 * @return array Configuration Data
 * @author Fran Iglesias
 */
	public function config($key = null)
	{
		if ($key) {
			return self::$configuration[$key];
		}
		return self::$configuration;
	}
}

?>