<?php
/**
 * CakeMailer
 * 
 * Adapter for CakePHP 1.3 Email Component
 *
 * @package fi_messenger
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

App::import('Lib', 'fi_messenger/AbstractMessenger');
App::import('Lib', 'fi_messenger/FiMessage');

class LogMessenger extends AbstractMessenger{

	
	# Interface implementation
	
	public function send(FiMessage $Message)
	{
		$message = $Message->getSubject();
		$log = $this->getRecipient();
		file_put_contents(LOGS.$log.'.log', date('Y-m-d H:i > ').$message.chr(10), FILE_APPEND);
		return true;
	}

	public function getErrors()
	{
		return false;
	}

	public function useTemplate($template = '')
	{
		return $this;
	}
	
}
?>