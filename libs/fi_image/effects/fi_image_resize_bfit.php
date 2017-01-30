<?php

App::import('Lib', 'fi_image/effects/FiImageResizeScale');
App::import('Lib', 'fi_image/services/FiImageResizeService');
App::import('Lib', 'fi_image/services/FiImageCanvasServices');
App::import('Lib', 'fi_image/values/FiCoordinates');

class FiImageResizeBfit extends FiAbstractImageFilterDecorator
{
	protected $Position;
	
	function __construct(FiImageInterface $Image, FiImageSize $NewSize)
	{
		$this->Image = $Image;
		$this->TargetSize = $NewSize;
		$CanvasService = new FiImageCanvasService();
		$this->Canvas = $CanvasService->get($this->TargetSize);
		$this->Position = new FiCoordinates(
			($this->TargetSize->width() - $this->size()->fit($this->TargetSize)->width())/2,
			($this->TargetSize->height() - $this->size()->fit($this->TargetSize)->height())/2
		);
	}
	
	public function apply()
	{
		imagecopyresampled(
			$this->Canvas->get(), 
			$this->Image->get(), 
			$this->Position->x(), 
			$this->Position->y(), 
			0, 0, 
			$this->size()->fit($this->TargetSize)->width(), 
			$this->size()->fit($this->TargetSize)->height(), 
			$this->size()->width(), 
			$this->size()->height()
		);
		$this->Image->set($this->Canvas->get());
	}
	
}



?>