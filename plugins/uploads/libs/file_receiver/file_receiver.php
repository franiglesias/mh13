<?php

App::import('Lib', 'Uploads.interfaces/FileReceiverInterface');
App::import('Lib', 'Uploads.file_receiver/XhrUploadFileStrategy');
App::import('Lib', 'Uploads.file_receiver/FormUploadFileStrategy');
App::import('Lib', 'Uploads.file_receiver/NullUploadFileStrategy');
App::import('Lib', 'Uploads.UploadedFile');

class FileReceiver implements FileReceiverInterface
{
	private $UploadStrategy;
	private $mode = null;
	private $maxSize = 314572800; // 300 MB
	private $validExtensions = false;
	
	public function __construct($validExtensions = false, $maxSize = null)
	{
		$this->validExtensions = $validExtensions;
		if ($maxSize) {
			$this->maxSize = $maxSize;
		}
		$this->UploadStrategy = $this->selectStrategy();
	}
	
	public function setStrategy(FileUploadStrategyInterface $UploadStrategy)
	{
		$this->UploadStrategy = $UploadStrategy;
	}
	
	private function selectStrategy()
	{
        if (isset($_GET['qqfile'])) {
			$this->mode = 'xhr';
            return new XhrUploadFileStrategy();
        } elseif (isset($_FILES['qqfile'])) {
			$this->mode = 'form';
            return new FormUploadFileStrategy();
        }
		$this->mode = 'null';
        return new NullUploadFileStrategy(); 
	}

	public function save($uploadPath)
	{
		file_put_contents(LOGS.'mh-uploads.log', date('Y-m-d H:i > ').'[Receiver] '.$uploadPath.chr(10), FILE_APPEND);
		$fileName = $this->avoidConflict($uploadPath, $this->normalizeFileName());
		$fileName .= '.'.pathinfo($this->UploadStrategy->getName(), PATHINFO_EXTENSION);
		try {
			$this->checkPermissions($uploadPath);
			$this->checkExtension();
			$this->checkEmpty();
			$this->checkSize();
			$this->UploadStrategy->save($uploadPath.$fileName);
			$Response = new UploadedFile($uploadPath.$fileName);
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}
		return $Response;
	}
	
	private function avoidConflict($uploadPath, $fileName)
	{
        while (file_exists($uploadPath.$fileName)) {
            $fileName .= '-'.mt_rand(10, 99);
        }
		return $fileName;
	}

	private function normalizeFileName()
	{
		$fileName = pathinfo($this->UploadStrategy->getName(), PATHINFO_FILENAME);
		$fileName = mb_convert_encoding($fileName, "ISO-8859-1", "UTF-8");
		return Inflector::slug(
			mb_convert_encoding(
				str_replace('?', '', mb_strtolower($fileName)), 
				"UTF-8", "ISO-8859-1"
			)
		);
	}
	
	public function mode()
	{
		return $this->mode;
	}

	
	private function checkSize()
	{
		if ($this->UploadStrategy->getSize() > $this->maxSize) {
			throw new RuntimeException('Receiver: The file is too large.', 1);
		}
	}
	
	private function checkEmpty()
	{
		if ($this->UploadStrategy->getSize() === 0) {
			throw new RuntimeException('Receiver: The file is empty.', 1);
		}
	}
	
	private function checkExtension()
	{
		if (!$this->validExtensions) {
			return false;
		}
		$extension = strtolower(pathinfo($this->UploadStrategy->getName(), PATHINFO_EXTENSION));
		if (!in_array($extension, $this->validExtensions)) {
			throw new RuntimeException('Receiver: File extension is invalid.', 1);
		}
	}
	
	private function checkPermissions($uploadPath)
	{
		if (!is_writable($uploadPath)) {
			throw new RuntimeException('Receiver: Upload path is not writable. '.$uploadPath, 1);
		}
	}

}



?>

