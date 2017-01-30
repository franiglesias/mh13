<?php

App::import('Lib', 'fi_image/effects/FiImageResizeScale');
App::import('Lib', 'fi_image/services/FiImageResizeService');
App::import('Lib', 'fi_image/services/FiImageCanvasService');
App::import('Lib', 'fi_image/services/FiImageCropService');

class FiImageResizeFill extends FiAbstractImageFilterDecorator
{
	protected $Cropper;
	
	function __construct(FiImageInterface $Image, FiImageSize $NewSize)
	{
		$this->Image = $Image;
		$this->TargetSize = $NewSize;
		$CanvasService = new FiImageCanvasService();
		$this->Canvas = $CanvasService->get($this->size()->fill($NewSize));
		$From = new FiCoordinates(
			($this->Canvas->width() - $this->TargetSize->width())/2,
			($this->Canvas->height() - $this->TargetSize->height())/2
		);
		$this->Cropper = new FiImageCropService($From, $this->TargetSize);
	}
	
	public function apply()
	{
		imagecopyresampled(
			$this->Canvas->get(), 
			$this->Image->get(), 
			0, 0, 0, 0, 
			$this->Canvas->width(), 
			$this->Canvas->height(), 
			$this->size()->width(), 
			$this->size()->height()
		);
		$result = $this->Cropper->crop($this->Canvas->get());
		$this->Image->set($result->get());
	}
		
}



?>