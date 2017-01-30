<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');
App::import('Lib', 'fi_image/services/FiImageCanvasService');

class FiImageResizeScale extends FiAbstractImageFilterDecorator
{
	protected $TargetSize;
	protected $Canvas;
	
	function __construct(FiImageInterface $Image, FiImageSize $NewSize)
	{
		$this->Image = $Image;
		$this->TargetSize = $NewSize;
		$CanvasService = new FiImageCanvasService();
		$this->Canvas = $CanvasService->get($NewSize);
	}
	
	public function apply()
	{
		$OldSize = $this->size();
		imagecopyresampled($this->Canvas->get(), $this->Image->get(), 0, 0, 0, 0, $this->Canvas->width(), $this->Canvas->height(), $OldSize->width(), $OldSize->height());
		$this->Image->set($this->Canvas->get());
	}
	
	
}



?>