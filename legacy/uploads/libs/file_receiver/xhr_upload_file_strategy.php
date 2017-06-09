<?php

App::import('Lib', 'Uploads.interfaces/FileUploadStrategyInterface');
	/**
	 * Handle file uploads via XMLHttpRequest
	 */
	class XhrUploadFileStrategy extends Object implements FileUploadStrategyInterface{
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
				return null;
	            // throw new Exception('Getting content length is not supported.');
	        }      
	    }   
	}


?>
