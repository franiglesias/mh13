<?php

App::import('Lib', 'fi_image/interfaces/FiImageInterface');

App::import('Lib', 'fi_image/abstracts/FiAbstractImageDecorator');

App::import('Lib', 'fi_image/interfaces/FiFilePathInterface');
App::import('Lib', 'fi_image/values/FiNewFilePath');
App::import('Lib', 'fi_image/values/FiFilePath');

abstract class FiAbstractImageFileDecorator extends FiAbstractImageDecorator
{
	protected $quality;
	protected $Path;
	
	public function __construct(FiImageInterface $Image, FiFilePathInterface $Path, $quality = 100)
	{
		$this->Path = $Path;
		$this->Image = $Image;
		$this->quality = $quality;
		if (file_exists($this->Path->get())) {
			$this->read();
		}
	}

	public function path()
	{
		return $this->Path;
	}
	
	public function writeAs(FiFilePathInterface $Path)
	{
		if (!is_resource($this->Image->get())) {
			$this->read();
		}
		$this->Path = $Path;
		$this->write();
	}
	
	
	
}

?>