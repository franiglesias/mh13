<?php
/**
 *  Notify Component
 *
 *  Created on Thu Sep 23 17:17:11 CEST 2010.
 **/


class NotifyComponent extends Object {
	
	var $components = array('Email');
	var $Controller;
		
// The initialize method is called before the controller's beforeFilter method.
// 	
	function initialize(&$controller, $options=array()) {
		$this->Controller = $controller;
	}

	public function send($template, $to, $subject, $content = false) {
		$this->Email->reset();
		$this->Email->smtpOptions = array(
	    	'port'=> Configure::read('Mail.port'), 
			'timeout'=>'60',
			'auth' => true,
			'host' => Configure::read('Mail.host'),
			'username'=> Configure::read('Mail.username'),
			'password'=> Configure::read('Mail.password'),
		);

    	/* Set delivery method */
	    $this->Email->delivery = 'mail';
		$this->Email->sendAs = 'both';
		
		$this->Email->from    = Configure::read('Mail.from');
		$this->Email->to      = $to;
		$this->Email->subject = $subject;
		$this->Email->template = $template;
		if (!$this->Email->send($content)) {
		    $this->Controller->set('smtp_errors', $this->Email->smtpError);
			$message = 'Error trying to send email. '.implode('. ', $this->Email->smtpError);
			$this->log($message,'notify');
			file_put_contents(LOGS.'fi_notify.log', date('Y-m-d H:i > ').$message.chr(10), FILE_APPEND);
			throw new RuntimeException(__d('errors', 'Email not sent.', true));
		}
		$to = implode(', ', (array)$to);
		$message = sprintf('Notification sent to: %s, with subject "%s"', $to, $subject);
		$this->log($message,'notify');
		file_put_contents(LOGS.'fi_notify.log', date('Y-m-d H:i > ').$message.chr(10), FILE_APPEND);
	}
}


?>