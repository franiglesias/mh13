<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');

/**
 * Applies a blur effect on an image
 *
 * @package effects.FiImage.Milhojas
 * @author Fran Iglesias
 */
class FiImageBlur extends FiAbstractImageFilterDecorator
{
	function __construct(FiImageInterface $Image, $intensity = 30)
	{
		$this->Image = $Image;
		$this->maxIntensity = 10;
		$this->intensity = $this->normalize($intensity);
	}
	
	public function apply()
	{
		for ($i=0; $i <= $this->intensity; $i++) { 
			$this->applyBlur();
		}
		$this->brightnessCorrection();
	}
	
	# Steps
	
	private function applyBlur()
	{
		imagefilter($this->Image->get(), IMG_FILTER_GAUSSIAN_BLUR);
		imagefilter($this->Image->get(), IMG_FILTER_GAUSSIAN_BLUR);
	}
	
	private function brightnessCorrection()
	{
		imagefilter($this->Image->get(), IMG_FILTER_BRIGHTNESS, $this->intensity);
	}
}



?>