<?php

/**
* 
*/
class UiWidget
{
	var $Widget;
	
	var $defaults = array();
	
	function __construct($widget)
	{
		$this->Widget = $widget;
	}
	
	public function code($options = array())
	{
		// Overwrite
		return '<p>HTML for Widget</p>'
	}
}


?>