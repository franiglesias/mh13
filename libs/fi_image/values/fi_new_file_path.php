<?php
App::import('Lib', 'fi_image/values/FiFilePath');
/**
* Contains a path for a new file, ensuring:
* 
* directory exists and in writable
* a file with that path does not exists
* 
* Throw exceptions if the path cannot be used
*/
class FiNewFilePath extends FiFilePath
{
	
	protected function isValidPath($path)
	{
		$this->existentDirCheck($path);
		$this->writableDirCheck($path);
		$this->fileDoesNotExistCheck($path);
		
	}
	
	private function existentDirCheck($path)
	{
		$dir = pathinfo($path, PATHINFO_DIRNAME);
		if (!file_exists($dir)) {
			throw new RuntimeException(sprintf('Path does not exists: %s.', $dir), 1);
		}
	}
	
	private function writableDirCheck($path)
	{
		$dir = pathinfo($path, PATHINFO_DIRNAME);
		if (!is_writable($dir)) {
			throw new RuntimeException(sprintf('Path is not writable: %s.', $dir), 1);
		}
	}
	
	public function fileDoesNotExistCheck($path)
	{
		if (file_exists($path)) {
			throw new RuntimeException(sprintf('File %s exists', $path), 1);
		}
	}
}


?>