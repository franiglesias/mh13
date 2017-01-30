<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* Formats a string using a printf template
*/
class HtmlFormatter extends FiFormatter
{
	
	public function format()
	{
		$text = $this->_Value->get();
		$text = preg_replace('/^(.*)$/m', '<p>$1</p>', $text);
		return trim($text);
	}
}


?>
