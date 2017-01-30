<?php
/**
 *  normalizer
 *
 *  Created by  on 2009-12-27.
 *  Copyright (c) 2009 Fran Iglesias. All rights reserved.
 **/

/**
* Normalizar
*/
class PostProcessor
{
	var $image;
	
	var $defaults = array();
	
	var $params;
	
	function __construct($image, $params = array())
	{
		$this->image = $image;
		$this->params = Set::merge($this->defaults, $params);
	}
	
	function main() 
	{
	}
}


?>
