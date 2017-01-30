<?php

App::import('Lib', 'fi_image/values/FiImageColor');

class FiImageText
{
	private $text;
	private $fontSize;
	private $pad;
	private $Color;
	private $font;
	private $Size;
	
	function __construct($text, $fontSize, $pad, $color, $font)
	{
		$this->text = $text;
		$this->fontSize = $fontSize;
		$this->pad = $pad;
		$this->Color = new FiImageColor($color);
		$this->font = $font;
		$this->Size = $this->computeSize();
		
	}
	
	private function computeSize()
	{
		$theBox = imageftbbox($this->fontSize, 0, $this->font, $this->text);
		return new FiImageSize(
			($this->pad * 2) + $theBox[0] - $theBox[2],
			($this->pad * 2) + $theBox[3] - $theBox[5]
		); 
	}
	
	public function getSize()
	{
		return $this->Size;
	}
	
	public function height()
	{
		return $this->Size->height();
	}
	
	public function applyTo($image)
	{
		imagefttext($image, $this->fontSize, 0, $this->pad, imagesy($image)-$this->pad, -1 * $this->Color->get(), $this->font, $this->text);
	}
}


?>