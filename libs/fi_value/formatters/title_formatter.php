<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* Formats a string using a printf template
*/
class TitleFormatter extends FiFormatter
{
	public function format()
	{
		$temp = $this->_Value->get();
		$temp[0] = mb_strtoupper($temp[0]);
		return $temp;
	}
}


?>
