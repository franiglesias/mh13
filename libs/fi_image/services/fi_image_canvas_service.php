<?php

App::import('Lib', 'fi_image/values/FiImageCanvas');

class FiImageCanvasService

{
	function __construct()
	{
	}
	
	public function get(FiImageSize $Size, FiImageColor $Color = null)
	{
		if (!$Color) {
			$Color = new FiImageColor('fff');
		}
		return new FiImageCanvas($Size, $Color);
	}
	
	public function null()
	{
		return new FiImageNullCanvas();
	}
}


?>
