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





/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr extends Object{
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
	
	public function save($path) {
		$input = fopen('php://input', 'r');
		$target = fopen($path, 'w');
		while ($data = fread($input, 8192)) {
			fwrite($target, $data);
		}
		fclose($target);
		fclose($input);
		return true;
	}

    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class FileUploader extends Object{
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;       

        if (isset($_GET['qqfile'])) {
			$this->log('Mode: XHR', 'uploads');
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
			$this->log('Mode: Form', 'uploads');
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
 
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        if (!is_writable($uploadDirectory)){
            return $this->error('Server error. Upload directory isn\'t writable.');
        }

        if (!$this->file){
            return $this->error('No files were uploaded.');
        }

        if ($this->file->getSize() > $this->sizeLimit) {
            return $this->error('File is too large');
        }

        $pathinfo = pathinfo($this->file->getName());

		// $this->log('File uploaded. Information: ', 'uploads');
		// foreach ($pathinfo as $key => $value) {
		// 	$this->log(' '.$key.' => '.$value, 'uploads');
		// }

        $filename = $pathinfo['filename'];
		$filename = $this->normalizeFileName($filename);
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return $this->error('File has an invalid extension, it should be one of '. $these . '.');
        }

        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }

        $finalSize = 0;

		/**
		 * Returns some more info about the file
		 */
		$theFile = $uploadDirectory . $filename . '.' . $ext;

        if ($this->file->save($theFile)){
			$this->log('Storing file '.$theFile, 'uploads');
			$finalSize = filesize($theFile);
        }

		if ($finalSize > 0) {
            return array(
				'success'=>true,
				'tmp' => $theFile,
				'error' => false
				);
		}

        return $this->error('Could not save uploaded file. Empty file.');
    }

    /**
     * Returns an error array. We want a normalized response
     *
     * @param string $message
     *
     * @return array with the content for ajax response
     */
    protected function error($message)
    {
        $this->log('Upload error: '.$message, 'uploads');

        return array(
            'success' => false,
            'tmp' => false,
            'error' => $message,
        );
    }

    /**
     * Returns a normalized file name to avoid problems with url and special chars
     *
     * Solves some problems with fileName UTF-8 encoding
     *
     * @param  string the name we want to normalize
     *
     * @return string normalized name
     *
     **/

    protected function normalizeFileName($fileName)
    {
        if (empty ($fileName)) {
            $fileName = __('untitled', true);
        }
        $fileName = mb_convert_encoding($fileName, "ISO-8859-1", "UTF-8");
        $fileName = str_replace('?', '', $fileName);

        return Inflector::slug(mb_convert_encoding($fileName, "UTF-8", "ISO-8859-1"));
    }
}

?>
