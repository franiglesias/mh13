<?php

App::import('Lib', 'fi_image/values/FiImageSize');
App::import('Lib', 'fi_image/values/FiImageColor');

class FiImageCanvas 
{
	private $resource;
	private $Size;
	
	public function __construct(FiImageSize $Size, FiImageColor $Color)
	{
		$this->Size = $Size;
		$this->resource = $this->create($Color);
	}
	
	protected function create(FiImageColor $Color)
	{
		$canvas = imagecreatetruecolor($this->Size->width(), $this->Size->height());
		imagealphablending($canvas, false);
		imagesavealpha($canvas, true);
		imagefill($canvas, 0, 0, $Color->get());
		return $canvas;
	}
	
	public function get()
	{
		return $this->resource;
	}
	
	public function size()
	{
		return $this->Size;
	}
	
	public function width()
	{
		return $this->Size->width();
	}
	
	public function height()
	{
		return $this->Size->height();
	}
}
?>