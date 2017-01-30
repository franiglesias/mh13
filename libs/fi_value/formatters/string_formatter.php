<?php
App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* Formats a string using a printf template
*/
class StringFormatter extends FiFormatter
{
	public function format()
	{
		return sprintf($this->_format, $this->_Value->get());
	}
}


?>
