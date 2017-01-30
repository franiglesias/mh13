<?php

App::import('Lib', 'fi_image/effects/FiImageColorize');

/**
 * Old sepia effect, derived from colorize
 *
 * @package effects.FiImage.Milhojas
 * @author Fran Iglesias
 */
class FiImageSepia extends FiImageColorize
{
	
	function __construct(FiImageInterface $Image, $intensity = 50)
	{
		parent::__construct($Image, new FiImageColor('8f633f'), $intensity);
	}
		
}

?>