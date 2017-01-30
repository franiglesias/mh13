<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');
App::import('Lib', 'fi_image/services/FiImageCanvasService');
/**
 * Creates a pixelated effect. Intensity from 0 to 100
 *
 * @package effects.FiImage.Milhojas
 * @author Fran Iglesias
 */
class FiImagePixelate extends FiAbstractImageFilterDecorator
{
	protected $Canvas;
	function __construct(FiImageInterface $Image, $intensity = 50, $module = 4)
	{
		$this->Image = $Image;
		$this->maxIntensity = $module;
		$this->intensity = $this->normalize($intensity);
		$CanvasService = new FiImageCanvasService();
		$this->Canvas = $CanvasService->get($this->size()) ;
	}
	
	protected function normalize($intensity)
	{
		if (!$intensity) {
			$intensity = 1;
		}
		$Size = $this->size();
		if ($Size->width() < $Size->height()) {
			return $Size->width() * $this->pixelationFactor($intensity);
		} else {
			return $Size->height() * $this->pixelationFactor($intensity);
		}
	}
	
	private function pixelationFactor($intensity)
	{
		return $intensity / (100 * $this->maxIntensity);
	}
	
	public function apply()
	{
		$xPixelation = round($this->size()->width() / $this->intensity);
		$yPixelation = round($this->size()->height() / $this->intensity);
		imagecopyresized(
			$this->Canvas->get(), 
			$this->Image->get(), 
			0, 0, 0, 0, 
			$xPixelation, 
			$yPixelation, 
			$this->size()->width(), 
			$this->size()->height()
		);
		imagecopyresized(
			$this->Image->get(), 
			$this->Canvas->get(), 
			0, 0, 0, 0, 
			$this->size()->width(), 
			$this->size()->height(), 
			$xPixelation, 
			$yPixelation
		);
	}

	
}



?>