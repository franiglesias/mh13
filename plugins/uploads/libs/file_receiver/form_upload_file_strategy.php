<?php
/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
App::import('Lib', 'Uploads.interfaces/FileUploadStrategyInterface');

class FormUploadFileStrategy implements FileUploadStrategyInterface{  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
			throw new RuntimeException('Unable to move upload to destination', 1);
        }
    }

    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}


?>