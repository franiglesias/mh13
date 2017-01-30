<?php

App::import('Lib', 'fi_image/interfaces/FiFilePathInterface');

class FiFilePath implements FiFilePathInterface
{
	private $path;

	function __construct($path)
	{
		try {
			$this->isValidPath($path);
			$this->path = $path;
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function isValidPath($path)
	{
		if (is_dir($path)) {
			throw new InvalidArgumentException(sprintf('Path is not a file: %s.', $path), 1);
		}
		if (!file_exists($path)) {
			throw new InvalidArgumentException(sprintf('File does not exist: %s.', $path), 1);
		}
		if (!is_writable($path)) {
			throw new InvalidArgumentException(sprintf('File is not writable: %s.', $path), 1);
		}
	}
	
	public function get()
	{
		return $this->path;
	}

	public function dir()
	{
		return pathinfo($this->path, PATHINFO_DIRNAME).'/';
	}

	public function setExtension($extension)
	{
		$parts = pathinfo($this->path);
		$this->path = $parts['dirname'].'/'.$parts['filename'].'.'.$extension;
	}
}	


?>