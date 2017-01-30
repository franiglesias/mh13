<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* Formats a string using a printf template
*/
class CapitalizeFormatter extends FiFormatter
{
	public function format()
	{
		$temp = mb_strtolower($this->_Value->get());
		$temp[0] = mb_strtoupper($temp[0]);
		return $temp;
	}
}


?>
