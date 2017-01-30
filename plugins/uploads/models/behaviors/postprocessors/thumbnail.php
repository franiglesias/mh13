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
class Thumbnail extends PostProcessor
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
		foreach ($this->params as $size) {
			$options = Set::merge($this->defaults, $size);
			$Image->thumb($this->image, $options);
		}
		return;
	}
}



?>