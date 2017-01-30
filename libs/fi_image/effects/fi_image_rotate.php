<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFilterDecorator');


class FiImageRotate extends FiAbstractImageFilterDecorator
{
	protected $degrees;
	
	function __construct(FiImageInterface $Image, $degrees)
	{
		$this->Image = $Image;
		$this->degrees = $degrees;
	}
	
	public function apply()
	{
		$Transparent = new FiImageColor('000',0);
		$tmp = imagerotate($this->Image->get(), $this->degrees, $Transparent->get(), 0);
		imagedestroy($this->Image->get());
		$this->Image->set($tmp);
		imagealphablending($this->Image->get(), false);
		imagesavealpha($this->Image->get(), true);
	}
}


?>