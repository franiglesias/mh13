<?php


interface DispatchedFileInterface {
	public function setBasePath($base);
	public function setFolder($folder);
	public function setName($name);
	
	public function getReceivedFile();
	public function getResponse();

	public function getName();
	public function getPath();
	public function getFullPath();
	public function setDispatched();
}

?>