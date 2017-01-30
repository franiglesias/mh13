<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* Converts an array into a string with a separator and a last separator
*/
	class ListFormatter extends FiFormatter
	{
		public function __construct(FiValue $Value, $format)
		{
			if (!is_array($format)) {
				$format = array('separator' => $format, 'last' => $format);
			}
			parent::__construct($Value, $format);
		
		}
		public function format()
		{
			$value = $this->_Value->get();
			if (!is_array($value)) {
				return $value;
			}
			extract($this->_format);
			$lastElement = array_pop($value);
			$value = implode($separator, $value).$last.$lastElement;
			return $value;
		}
	}


?>
