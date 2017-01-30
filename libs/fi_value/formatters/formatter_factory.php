<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* 
*/
class FormatterFactory
{
	public function __construct()
	{
	}
	
	public function get(FiValue $Value, $formatter, $params = null)
	{
		$className = ucfirst($formatter).'Formatter';
		App::import('Lib', 'fi_value/formatters/'.$className);
		if (!class_exists($className)) {
			throw new RunTimeException(sprintf('%s class doesn\'t exist.', $className));
		}	
		return new $className($Value, $params);
	}
	
	public function build(FiValue $Value, $formatters)
	{
		foreach ($formatters as $format => $options) {
			// debug($format);
			// debug($options);
			if (is_numeric($format)) {
				if (is_array($options)) {
					$format = key($options);
					$options = $options[$format];
				} else {
					$format = $options;
					$options = false;
				}
			}
			// debug($format);
			// debug($options);
			
			// if (!is_string($format)) {
			// 	$format = key($options);
			// 	$options = $options[$format];
			// }
			$Value = $this->get($Value, $format, $options);
		}
		return $Value;
	}

}


?>