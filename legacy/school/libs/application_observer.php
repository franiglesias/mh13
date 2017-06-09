<?php

App::import('Lib', 'events/FiObserver');
App::import('Lib', 'fi_messenger/Message');
App::import('Lib', 'events/AbstractObserver');
App::import('Helper', 'School.Application');
/**
* 
*/
class ApplicationObserver extends AbstractObserver
{
	protected $Mailer;
	protected $ApplicationHelper;
	
	public function __construct()
	{
		$this->ApplicationHelper = new ApplicationHelper();
		$this->ApplicationHelper->setDataProviderFactory(new DataProviderFactory());
	}
	
	public function useMailer($Mailer)
	{
		$this->Mailer = $Mailer;
	}
	
	public function received($Application)
	{
		$data = $Application->read(null);
		$this->ApplicationHelper->bind($data);
		$this->Mailer->set('application', $data);
		$this->Mailer->set('levels', $this->ApplicationHelper->levels);
		$this->Mailer->set('sections', $this->ApplicationHelper->sections);
		$Success = new Message();
		$Success->setRecipient($this->ApplicationHelper->email());
		$Success->setSender(Configure::read('Mail.from'));
		$Success->setSubject(__d('school', 'Your application for our school', true));
		$this->Mailer->useTemplate('/school/application_success')->send($Success);
		unset($Success);
		
		$Received = new Message();
		$Received->setRecipient(Configure::read('School.applications.notify_email'));
		$Received->setSender(Configure::read('Mail.from'));
		$Received->setSubject(__d('school', 'Application received', true));
		$this->Mailer->useTemplate('/school/application_received')->send($Received);
		unset($Received);
		
		$this->log('Application received for '.$this->ApplicationHelper->email(), 'school');
	}
	
}


?>