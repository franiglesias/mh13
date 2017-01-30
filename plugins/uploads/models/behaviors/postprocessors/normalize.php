<?php
/**
 *  normalizer
 *
 *  Created by  on 2009-12-27.
 *  Copyright (c) 2009 Fran Iglesias. All rights reserved.
 **/

require_once('post_processor.php');

/**
* Normalizar
*/
class Normalize extends PostProcessor
{
	var $defaults = array(
		'method' => 'fit',
		'prefix' => 'thumb',
		'width' => 100,
		'height' => 75,
		'img' => false
		);
	
	function main() 
	{
		App::import('Lib', 'FiImage');
		$Image = new FiImage();
		return $Image->transform($this->image, $this->params);
	}
}


?>