<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');

/**
 * Converts an image to Grayscale
 *
 * @package effects.FiImage.Milhojas
 * @author Fran Iglesias
 */
class FiImageGrayscale extends FiAbstractImageFilterDecorator
{

	function __construct(FiImageInterface $Image)
	{
		$this->Image = $Image;
	}
	
	public function apply()
	{
		imagefilter($this->Image->get(), IMG_FILTER_GRAYSCALE);
	}
	
}



?>