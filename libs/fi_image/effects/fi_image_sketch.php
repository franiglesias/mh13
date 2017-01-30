<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');

/**
 * Creates a nice pictorical effect, much like drew by hand
 *
 * @package effects.FiImage.Milhojas
 * @author Fran Iglesias
 */
class FiImageSketch extends FiAbstractImageFilterDecorator
{
	function __construct(FiImageInterface $Image)
	{
		$this->Image = $Image;
		$this->intensity = 50;
	}
	
	public function apply()
	{
		$this->sketch();
		$this->smooth();
	}
	
	private function sketch()
	{
		imagefilter($this->Image->get(), IMG_FILTER_MEAN_REMOVAL);
		imagefilter($this->Image->get(), IMG_FILTER_CONTRAST, -$this->intensity);
		
	}
	
	private function smooth()
	{
		imagefilter($this->Image->get(), IMG_FILTER_GAUSSIAN_BLUR);
		imagefilter($this->Image->get(), IMG_FILTER_GAUSSIAN_BLUR);
	}
}



?>