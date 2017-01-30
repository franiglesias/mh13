<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');

/**
 * Changes the luminosity of a image from -100 to 100
 *
 * @package effects.FiImage.Milhojas
 * @author Fran Iglesias
 */
class FiImageBrightness extends FiAbstractImageFilterDecorator
{
	
	function __construct(FiImageInterface $Image, $intensity = 20)
	{
		$this->Image = $Image;
		$this->maxIntensity = 100;
		$this->intensity = $this->normalize($intensity);
	}
	
	public function apply()
	{
		imagefilter($this->Image->get(), IMG_FILTER_BRIGHTNESS, $this->intensity);
	}
	

}

?>