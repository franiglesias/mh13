<?php
/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
interface FileUploadStrategyInterface {  
	public function save($path);
	public function getName();
	public function getSize();
}


?>
