<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* Formats a string using a printf template
*/
class LowercaseFormatter extends FiFormatter
{
	public function format()
	{
		return mb_strtolower($this->_Value->get());
	}
}


?>
