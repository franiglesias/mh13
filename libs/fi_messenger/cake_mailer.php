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

App::import('Component', 'Email');
App::import('Core', 'Controller');
App::import('Lib', 'fi_messenger/AbstractMessenger');
App::import('Lib', 'fi_messenger/FiMessage');

class CakeMailer extends AbstractMessenger{

	/**
	 * Array containing the names of components this component uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	public $Email;
	private $Controller;

	public function __construct()
	{
	}
	
	# Interface implementation
	
	public function send(FiMessage $Message)
	{
		$this->Email->reset();
		$this->Email->from = $Message->getSender();
		$this->Email->to = $Message->getRecipient();
		$this->Email->subject = $Message->getSubject();
		$this->Email->template = $this->template;
		return $this->Email->send($Message->getContent());
	}

	public function getErrors()
	{
		$this->Email->smtpError;
	}

	public function useTemplate($template)
	{
		if (strpos($template, '/') === 0) {
			$plugin = substr($template, 1, strpos($template, DS, 1)-1);
			$template = substr($template, strpos($template, DS, 1)+1);
			$this->Email->Controller->plugin = $plugin;
		}
		$this->template = $template;
		return $this;
	}
	
	# Configuration

	public function init($CakeController, $CakeEmail)
	{
		$this->Email = $CakeEmail;
		$this->Email->initialize($CakeController);
		$this->Email->sendAs = 'both';
	}
	
	public function smtp($smtp = array())
	{
		$this->Email->smtpOptions = $smtp;
		$this->Email->delivery = 'smtp';
		$this->Email->sendAs = 'both';
	}

	public function set($var, $data)
	{
		$this->Email->Controller->set($var, $data);
	}
}
?>