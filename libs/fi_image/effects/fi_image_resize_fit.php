<?php

App::import('Lib', 'fi_image/effects/FiImageResizeScale');
App::import('Lib', 'fi_image/services/FiImageResizeService');
App::import('Lib', 'fi_image/services/FiImageCanvasServices');

class FiImageResizeFit extends FiAbstractImageFilterDecorator
{
	function __construct(FiImageInterface $Image, FiImageSize $NewSize)
	{
		$this->Image = $Image;
		$this->TargetSize = $NewSize;
		// $Resizer = new FiImageResizeService($this->size(), $this->TargetSize);
		$CanvasService = new FiImageCanvasService();
		$this->Canvas = $CanvasService->get($this->size()->fit($NewSize));
	}
	
	public function apply()
	{
		imagecopyresampled(
			$this->Canvas->get(), 
			$this->Image->get(), 
			0, 0, 0, 0, 
			$this->Canvas->width(), 
			$this->Canvas->height(), 
			$this->Image->size()->width(), 
			$this->Image->size()->height()
		);
		$this->Image->set($this->Canvas->get());
	}
		
}



?>