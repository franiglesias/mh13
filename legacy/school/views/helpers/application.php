<?php
/**
 * ApplicationHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

App::import('Helper', 'SinglePresentationModel');
App::import('Model', 'School.Application');

class ApplicationHelper extends AppHelper
{
	var $model = 'Application';
	var $var = 'application';
	var $helpers = array('Html', 'Form', 'Ui.XHtml');
	var $statuses = array();
	
	protected $transitions;
	
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->definitions();
	}
	
	public function definitions()
	{
		$this->statuses = array(
			Application::RECEIVED => __d('school', 'Received', true),
			Application::OPENED => __d('school', 'Opened', true),
			Application::INTERVIEWED => __d('school', 'Interviewed', true),
			Application::ACCEPTED => __d('school', 'Accepted', true),
			Application::CLOSED => __d('school', 'Resolved', true)
 		);

		$this->sections = array(
			1 => __d('school', 'Science and technology', true),
			2 => __d('school', 'Humanitites and Social Studies', true)
		);
		
		$this->levels = array(
			14 => __d('school', '1st level', true),
			15 => __d('school', '2nd level', true)
		);
		
		$this->resolutions = array(
			Application::PENDING => __d('school', 'Pending', true),
			Application::REJECTED => __d('school', 'Rejected', true),
			Application::NOT_CONFIRMED => __d('school', 'Not confirmed', true),
			Application::ACCEPTED => __d('school', 'Accepted. Waiting for confirmation.', true),
			Application::CONFIRMED => __d('school', 'Confirmed', true)
		);
		
		$this->types = array(
			0 => __d('school', 'Reservation', true),
			1 => __d('school', 'New application', true)
		);

		$this->transitions = array(
			Application::RECEIVED => array(
				array(
					'action' => 'next', 
					'label' => __d('school', 'Open', true), 
					'class' => 'mh-btn-ok'
					),
				),
			Application::OPENED => array(
				array(
					'action' => 'next', 
					'label' => __d('school', 'Interview', true), 
					'class' => 'mh-btn-ok'
					),
				),
			Application::INTERVIEWED => array(
				array(
					'action' => 'next', 
					'label' => __d('school', 'Accept', true), 
					'class' => 'mh-btn-ok'
					),
				array(
					'action' => 'reject', 
					'label' => __d('school', 'Reject', true), 
					'class' => 'mh-btn-cancel'
					),
				),
			Application::ACCEPTED => array(
				array(
					'action' => 'next', 
					'label' => __d('school', 'Confirm', true), 
					'class' => 'mh-btn-ok'
					),
				array(
					'action' => 'reject', 
					'label' => __d('school', 'Reject', true), 
					'class' => 'mh-btn-cancel'
					),
			),
			Application::CLOSED => array(
			),
		);
	}
	public function getTransitionData($field)
	{
		return $this->transitions[$this->value($field)];
	}
		
	public function email()
	{
		return sprintf('%s (%s %s)', $this->value('email'), $this->value('first_name'), $this->value('last_name'));
	}
}
