<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');	
/**
* 
*/
class PrecisionFormatter extends FiFormatter
{
	
	public function __construct(FiValue $Value, $precision)
	{
		parent::__construct($Value, $precision);
	
	}
	
	public function format()
	{
		return number_format($this->_Value->get(), $this->_format);
	}
}

?>
