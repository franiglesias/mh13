<?php

App::import('Lib', 'events/FiObserver');
App::import('Lib', 'events/AbstractObserver');
// App::import('Core', 'ClassRegistry');
App::import('Lib', 'fi_mailer/CakeMailer');
//App::import('Helper', 'Access.User');
/**
* 
*/
class UserObserver extends AbstractObserver
{
	protected $Mailer;
	protected $ApplicationHelper;
	
	public function __construct()
	{
	}

	public function useMailer($Mailer)
	{
		$this->Mailer = $Mailer;
	}
	
	
	public function login($User)
	{
		$data = $User->read(null);
		$this->log(sprintf(__d('access','User %s login.',true), $data['User']['realname']), 'access');
	}
	
	public function logout($User)
	{
		$data = $User->read(null);
		$this->log(sprintf(__d('access','User %s logout.',true), $data['User']['realname']), 'access');
	}
	
	public function register($User)
	{
		$data = $User->read(null);
		$this->log(sprintf(__d('access','User %s registered with account %s.',true), $data['User']['realname'], $data['User']['username']), 'access');
	}
	
	public function activate($User)
	{
		$data = $User->read(null);
		$this->Mailer->set('user', $data);
		$Success = new Message();
		$Success->setRecipient($data['User']['email'].' ('.$data['User']['realname'].')');
		$Success->setSender(Configure::read('Mail.from'));
		$Success->setSubject(__d('access', 'Your account has been activated', true));
		$this->Mailer->useTemplate('/access/activate')->send($Success);
		unset($Success);
	}
	
	public function deactivate($User)
	{
		$data = $User->read(null);
		$this->Mailer->set('user', $data);
		$Success = new Message();
		$Success->setRecipient($data['User']['email'].' ('.$data['User']['realname'].')');
		$Success->setSender(Configure::read('Mail.from'));
		$Success->setSubject(__d('access', 'Your account has been deactivated', true));
		$this->Mailer->useTemplate('/access/deactivate')->send($Success);
		unset($Success);
	}
	
	public function forgot($User)
	{
		$data = $User->read(null);
		$this->Mailer->set('user', $data);
		$this->Mailer->set('ticket', $User->useTicket());
		$Success = new Message();
		$Success->setRecipient($data['User']['email'].' ('.$data['User']['realname'].')');
		$Success->setSender(Configure::read('Mail.from'));
		$Success->setSubject(__d('access','Recover your lost password.', true));
		$this->Mailer->useTemplate('/access/forgot')->send($Success);
		unset($Success);
	}
	
	
}


?>