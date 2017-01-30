<?php

App::import('Lib', 'fi_image/services/FiImageCanvasService');
App::import('Lib', 'fi_image/values/FiCoordinates');
/**
* 
*/
class FiImageCropService
{
	private $Coordinates;
	private $Size;
	private $Canvas;
	
	function __construct(FiCoordinates $Coord, FiImageSize $Size)
	{
		$this->Coordinates = $Coord;
		$this->Size = $Size;
		$CanvasService = new FiImageCanvasService();
		$this->Canvas = $CanvasService->get($this->Size);
	}
	
	public function crop($image)
	{
		imagecopyresampled(
			$this->Canvas->get(), 
			$image, 
			0, 0, $this->Coordinates->x(), $this->Coordinates->y(), 
			$this->Canvas->width(), 
			$this->Canvas->height(), 
			$this->Canvas->width(), 
			$this->Canvas->height() 
		);
		return $this->Canvas;
	}
}


?>