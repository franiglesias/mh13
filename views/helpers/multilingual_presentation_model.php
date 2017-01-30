<?php

App::import('Helper', 'SinglePresentationModel');

/**
* 
*/
class MultilingualPresentationModelHelper extends SinglePresentationModelHelper
{

	var $language = null;
	
	public function setLanguage($language = null)
	{
		$this->language = $language;
	}

	public function value($field)
	{
		$value = parent::value($field);
		if ($this->language && is_array($value)) {
			return $value[$this->language];
		}
		return $value;
	}
	
	public function mixValue($field, $separator = ' / ')
	{
		$value = parent::value($field);
		if (is_array($value)) {
			return implode($separator, $value);
		}
		return $value;
	}
	
}



?>