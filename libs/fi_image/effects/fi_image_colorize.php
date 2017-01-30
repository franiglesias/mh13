<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');
App::import('Lib', 'fi_image/services/FiImageCanvasService');
/**
 * Colorizes an image, based on grey levels
 *
 * Color is an Hex web color
 * Intensity from -100 to 100
 *
 * Negative intensities may produce strange results, but they're funny
 *
 * @package effects.FiImage.Milhojas
 * @author Fran Iglesias
 */
class FiImageColorize extends FiAbstractImageFilterDecorator
{
	protected $Color;
	protected $Canvas;
	
	function __construct(FiImageInterface $Image, FiImageColor $Color, $intensity = 50)
	{
		$this->Image = $Image;
		$this->intensity = $intensity;
		$CanvasService = new FiImageCanvasService();
		$this->Canvas = $CanvasService->get($this->size(), $Color);
	}
	
	public function apply()
	{
		imagecopymergegray(
			$this->Image->get(), 
			$this->Canvas->get(), 
			0,0,0,0, 
			$this->size()->width(), 
			$this->size()->height(), 
			$this->intensity
		);
	}
	
}

?>