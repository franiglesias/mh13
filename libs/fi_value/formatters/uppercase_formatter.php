<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* Formats a string using a printf template
*/
class UppercaseFormatter extends FiFormatter
{
	public function format()
	{
		return mb_strtoupper($this->_Value->get());
	}
}


?>
