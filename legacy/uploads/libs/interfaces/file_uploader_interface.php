<?php

interface FileUploaderInterface {
	public function handleUpload($uploadDirectory, $replaceOldFile = FALSE);
	public function setMaxSize($maxSize);
	public function setValidExtensions($validExtensions);
}
?>