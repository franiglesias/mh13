<?php


App::import('Lib', 'fi_image/interfaces/FiImageInterface');

App::import('Lib', 'fi_image/values/FiImageCanvas');

App::import('Lib', 'fi_image/values/FiImageNullCanvas');

App::import('Lib', 'fi_image/models/FiNullImage');

App::import('Lib', 'fi_image/formats/FiJpgImage');
App::import('Lib', 'fi_image/formats/FiPngImage');
App::import('Lib', 'fi_image/formats/FiGifImage');

App::import('Lib', 'fi_image/values/FiFilePath');
App::import('Lib', 'fi_image/values/FiNewFilePath');
App::import('Lib', 'fi_image/values/FiImageColor');
/**
* 
*/
class FiImageDispatcher
{
	public function get($file)
	{
		try {
			$Path = new FiFilePath($file);
			$info = getimagesize($Path->get());
			$Image = new FiImage(new FiImageNullCanvas());
			return $this->imageByType($info['mime'], $Path, $Image);
		} catch (Exception $e) {
			return new FiNullImage();
		}
	}
	
	private function imageByType($type, $Path, $Image)
	{
		switch ($type) {
			case 'image/jpeg':
				return new FiJpgImage($Image, $Path);
				break;
			case 'image/png':
				return new FiPngImage($Image, $Path);
				break;
			case 'image/gif':
				return new FiGifImage($Image, $Path);
				break;
			default:
				break;
		}
	}
	
	public function make($file, FiImageSize $Size, FiImageColor $Color, $type)
	{
		$Canvas = new FiImageCanvas($Size, $Color);
		return $this->imageByType($type, new FiNewFilePath($file), new FiImage($Canvas));
	}
	
	public function save(FiImageInterface $Image)
	{
		$Image->write();
	}
	
	public function duplicate(FiImageInterface $Image, $file)
	{
		$Copy = clone $Image;
		$Copy->writeAs(new FiNewFilePath($file));
		return $Copy;
	}
	
	public function move(FiImageInterface $Image, FiNewFilePath $Path)
	{
		# code...
	}
	
	public function delete(FiImageInterface $Image)
	{
		# code...
	}
}

?>