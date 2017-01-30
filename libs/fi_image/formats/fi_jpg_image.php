<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageFileDecorator');
/**
* 
*/
class FiJpgImage extends FiAbstractImageFileDecorator
{
	protected $quality = 100;
	
	public function read()
	{
		$this->Image->set(imagecreatefromjpeg($this->Path->get()));
	}
	
	public function write()
	{
		$this->Path->setExtension('jpg');
		imageinterlace($this->Image->get(), 1);
		if (!imagejpeg($this->Image->get(), $this->Path->get(), $this->quality)) {
			throw new RuntimeException(sprintf('Can not write image file %s', $this->Path->get()), 1);
		}
	}
		
	public function getType()
	{
		return 'image/jpeg';
	}
}


?>