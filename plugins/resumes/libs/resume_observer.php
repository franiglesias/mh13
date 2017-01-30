<?php

App::import('Lib', 'events/FiObserver');
App::import('Lib', 'fi_messenger/Message');
App::import('Lib', 'events/AbstractObserver');
/**
* 
*/
class ResumeObserver extends AbstractObserver
{
	protected $Mailer;
	
	public function __construct()
	{
	}
	
	public function useMailer($Mailer)
	{
		$this->Mailer = $Mailer;
	}
	
	public function received($Resume)
	{
		$data = $Resume->read(null);
		$this->Mailer->set('candidate', $data);
		$Success = new Message();
		$Success->setRecipient($data['Resume']['email']);
		$Success->setSender(Configure::read('Mail.from'));
		$Success->setSubject(__d('resumes', 'We have received your resume', true));
		$this->Mailer->useTemplate('/resumes/resumes_new_success')->send($Success);
		unset($Success);
		
		$Received = new Message();
		$Received->setRecipient(Configure::read('School.applications.notify_email'));
		$Received->setSender(Configure::read('Mail.from'));
		$Received->setSubject(__d('resumes', 'Resume received', true));
		$this->Mailer->useTemplate('/resumes/resumes_received')->send($Received);
		unset($Received);
		
		$this->log('Resume received for '.$data['Resume']['email'], 'school');
	}
	
}


?>