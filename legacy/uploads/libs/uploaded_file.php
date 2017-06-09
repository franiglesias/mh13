<?php

App::import('Lib', 'Uploads.interfaces/UploadedFileInterface');
App::import('Lib', 'Uploads.interfaces/DispatchedFileInterface');
/**
* Uploaded File
*/
class UploadedFile implements UploadedFileInterface, DispatchedFileInterface
{
	private $name;
	private $ext;
	private $base;
	private $folder;
	private $received;
	private $error;
	
	function __construct($receivedFilePath)
	{
		$this->received = $receivedFilePath;
	}
	
	public function getReceivedFile()
	{
		return $this->received;
	}
	public function getResponse()
	{
		return array(
			'success' => empty($this->error),
			'error' => $this->error,
			'file' => $this->getName(),
			'path' => $this->getPath(),
			'fullPath' => $this->getFullPath(),
			'remark' => false
		);
	}
	
	public function getName()
	{
		return $this->name;
	}

    public function setName($name)
    {
        $this->name = $name;
    }
	
	public function getPath()
	{
		return $this->folder.$this->name;
	}

    public function getFullPath()
	{
		return $this->base.$this->folder.$this->name;
	}

    public function setBasePath($base)
    {
        $this->base = $base;
    }

    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

	public function setDispatched()
	{
		$this->error = false;
	}
	
}


?>
