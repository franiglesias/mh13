<?php
/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
App::import('Lib', 'Uploads.interfaces/FileUploadStrategyInterface');

class NullUploadFileStrategy implements FileUploadStrategyInterface{  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
		return false;
    }
    function getName() {
		return false;
    }
    function getSize() {
		return false;
    }
}


?>