<?php
/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
interface FileReceiverInterface {  
	public function save($path);
}


?>
