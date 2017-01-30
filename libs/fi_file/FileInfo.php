<?php
require_once '/Library/WebServer/Documents/mh13/vendors/getid3/getid3/getid3.php';

/**
* Description
*/
class FileInfo
{
	private $Id3;
	
	function __construct(GetId3 $Id3)
	{
		$this->Id3 = $Id3;
	}
	
	public function getInfo($path)
	{
		$info = $this->Id3->analyze($path);
		list($type, $subtype) = explode('/', $info['mime_type']);
		switch ($type) {
			case 'image':
				$Reader = new ImageFileInfoReader($info);
				break;
			case 'video':
				$Reader = new VideoFileInfoReader($info);
				break;
			case 'audio':
				$Reader = new AudioFileInfoReader($info);
				break;
			default:
				$Reader = new PlainFileInfoReader($info);
			break;
		}
		return $Reader->getInfo();
	}
	
}

abstract class FileInfoReader {
	protected $info;
	
	public function __construct($info)
	{
		$this->info = $info;
	}
	
	abstract public function getInfo();
}

class PlainFileInfoReader extends FileInfoReader{
	
	public function getInfo()
	{
		return array(
			'name' => $this->info['filename'],
			'width' => null,
			'height' => null,
			'type' => $this->info['mime_type'],
			'size' => $this->info['filesize'],
			'playtime' => null
		);
	}
}


class ImageFileInfoReader extends FileInfoReader{
	
	public function getInfo()
	{
		return array(
			'name' => $this->info['filename'],
			'width' => $this->info['video']['resolution_x'],
			'height' => $this->info['video']['resolution_y'],
			'type' => $this->info['mime_type'],
			'size' => $this->info['filesize'],
			'playtime' => null
		);
	}
}

class VideoFileInfoReader extends FileInfoReader{
	public function getInfo()
	{
		return array(
			'name' => $this->info['filename'],
			'width' => $this->info['video']['resolution_x'],
			'height' => $this->info['video']['resolution_y'],
			'type' => $this->info['mime_type'],
			'size' => $this->info['filesize'],
			'playtime' => round($this->info['playtime_seconds'], 3, PHP_ROUND_HALF_UP)
		);
	}
}

class AudioFileInfoReader extends FileInfoReader{
	public function getInfo()
	{
		return array(
			'name' => $this->info['filename'],
			'width' => null,
			'height' => null,
			'type' => $this->info['mime_type'],
			'size' => $this->info['filesize'],
			'playtime' => round($this->info['playtime_seconds'], 3, PHP_ROUND_HALF_UP)
		);
	}
}


?>