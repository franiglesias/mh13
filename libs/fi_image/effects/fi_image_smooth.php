<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');

/**
 * Produces a somehow diffuminated effect
 *
 * @package effects.FiImage.Milhojas
 * @author Fran Iglesias
 */
class FiImageSmooth extends FiAbstractImageFilterDecorator
{
	function __construct(FiImageInterface $Image, $intensity = 30)
	{
		$this->Image = $Image;
		$this->maxIntensity = 10;
		$this->intensity = $this->normalize($intensity);
	}
	
	public function apply()
	{
		imagefilter($this->Image->get(), IMG_FILTER_SMOOTH, $this->intensity);
		imagefilter($this->Image->get(), IMG_FILTER_GAUSSIAN_BLUR);
	}
	
	
}



?>