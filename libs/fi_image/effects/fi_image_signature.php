<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');
App::import('Lib', 'fi_image/services/FiImageCanvasService');
App::import('Lib', 'fi_image/values/FiImageSize');
App::import('Lib', 'fi_image/values/FiImageText');
App::import('Lib', 'fi_image/values/FiImageColor');

/**
 * Adds a signature text, creating a full width translucent box ($opacity 0 - 100) to write the text
 * 
 * Text must be passed as a FiImageText object so it can contain all needed information
 *
 * @package effects.FiImage.Milhojas
 * @author Fran Iglesias
 */
class FiImageSignature extends FiAbstractImageFilterDecorator
{
	protected $Text;
	protected $Color;
	protected $Canvas;
	
	function __construct(FiImageInterface $Image, FiImageText $Text, FiImageColor $Color, $opacity = 50)
	{
		$this->Image = $Image;
		$this->intensity = $opacity;
		$this->Text = $Text;
		$CanvasService = new FiImageCanvasService();
		$this->Canvas = $CanvasService->get($this->size(), $Color);
		
	}
	
	public function apply()
	{
		$this->applyBox();
		$this->applyText();
	}
	
	# Steps
	
	private function applyBox()
	{
		$height = $this->Text->height();
		imagecopymerge(
			$this->Image->get(), 
			$this->Canvas->get(), 
			0, $this->size()->height()-$height,0,0, 
			$this->size()->width(), 
			$height, 
			$this->intensity
		);
	}
	
	private function applyText()
	{
		$this->Text->applyTo($this->Image->get());
	}

}



?>