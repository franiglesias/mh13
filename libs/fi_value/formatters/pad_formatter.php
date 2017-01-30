<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');	
/**
* 
*/
class PadFormatter extends FiFormatter
{
	private $defaults = array(
		'string' => ' ',
		'type' => STR_PAD_RIGHT
	);
	
	public function __construct(FiValue $Value, $chars)
	{
		if (!is_array($chars)) {
			$chars = array('chars' => $chars);
		}
		parent::__construct($Value, array_merge($this->defaults, $chars));
	}
	
	public function format()
	{
		extract($this->_format);
		return mb_substr(str_pad($this->_Value->get(), $chars, $string, $type), 0, $chars);
	}
	
}

?>
