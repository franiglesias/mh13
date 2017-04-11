<?php

/**
 * A class that sends Messages
 *
 * @package fi_messenger
 * @author Fran Iglesias
 */
interface FiMessenger {
	/**
	 * Sends a message
	 *
	 * @param FiMessage $Message 
	 * @return boolean true on success
	 * @author Fran Iglesias
	 */
	public function send(FiMessage $Message);
	/**
	 * Use a template for the message
	 *
     * @param string $template
     *
	 * @return a reference to itself so you can chain the method to send
	 * @author Fran Iglesias
	 */
	public function useTemplate($template);
	/**
	 * Returns errors if any
	 *
	 * @return array
	 * @author Fran Iglesias
	 */
	public function getErrors();
}
?>
