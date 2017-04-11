<?php
/**
 * FileUploader
 * 
 * File Uploader original code by Andrew Valums
 * 
 * Adapted for Milhojas by Fran Iglesias
 *
 * @package subpackage.package
 * @version $Rev$
 * @license MIT License
 * 
 * $Id$
 * 
 * $HeadURL$
 * 
 **/

App::import('Lib', 'Uploads.FileUploaderInterface');




class FileUploader extends Object implements FileUploaderInterface{
    private $file;

    function __construct(FileReceiverInterface $File){
		$this->file = $File;
    }

	public function setMaxSize($maxSize)
	{
		$this->sizeLimit = $maxSize;
	}
	
	public function setValidExtensions($validExtensions)
	{
		$this->allowedExtensions = $validExtensions;
	}

	public function success($destination)
	{
		return array(
			'success'=>true,
			'tmp' => $destination,
			'error' => false
			);
	}

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE)
	{
		if (substr($uploadDirectory, -1) !== '/') {
			$uploadDirectory .= '/';
		}

        $File = $this->file->save($uploadDirectory);

    }

    /**
     * Returns an error array. We want a normalized response
     *
     * @param string $message
     *
     * @return array with the content for ajax response
     */
    private function error($message)
    {
        $this->log('Upload error: '.$message, 'uploads');

        return array(
            'success' => false,
            'tmp' => false,
            'error' => $message,
        );
    }

}

?>
