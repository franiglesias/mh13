<?php

App::import('Lib', 'School.ApplicationState');
class ApplicationsController extends SchoolAppController {

	var $name = 'Applications';
	
	var $layout = 'backend';
	var $components = array(
		'Notify', 
		'Filters.SimpleFilters',
		'State' => array(
			'School.Application' => array(
				Application::RECEIVED => 'ReceivedApplicationState',
				Application::OPENED => 'OpenedApplicationState',
				Application::INTERVIEWED => 'InterviewedApplicationState',
				Application::ACCEPTED => 'AcceptedApplicationState',
				Application::CLOSED => 'ClosedApplicationState',
				)
			)
		);
	var $helpers = array('School.Application');
	/**
	 * Controller beforeFilter callback.
	 * Called before the controller action. 
	 * 
	 * @return void
	 */
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('start', 'apply', 'feedback', 'check', 'review');
	}
	
	function index() {
		$this->_setCommonOptions();
		$this->set('applications', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}
	
	public function edit($id = null) {
		// Second pass
		if (!empty($this->data['Application'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Application->create();
			}
			// Try to save
			if ($this->Application->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['Application'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			} else {
				$this->data['Application']['type'] = 1;
				$this->data['Application']['status'] = 0;
				$this->data['Application']['resolution'] = 0;
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		$this->_setCommonOptions();
	}
	
	protected function refreshModel($id)
	{
		$this->preserveAppData();
		if (!($this->data = $this->Application->read(null, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

	function apply($id = null) 
	{
		$this->layout = 'basic';
		if (!empty($this->data)) {
			if (!$id) {
				$this->Application->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			// Force new application
			$this->data['Application']['type'] = 1;
			if ($this->Application->save($this->data)) {
				$this->message('success');
				$this->Session->write('Application', $this->data);
				$this->Application->received($this->Application->id);
				$this->redirect(array(
					'action' => 'feedback'
				));
			} else {
				$this->message('validation');
			}
		}
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Application->read($fields, $id))) {
					$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('school', 'application', true)), 'flash_error');
					$this->redirect(array(
						'action' => 'feedback'
					));
				}
			}
		}
		$this->set('levels', $this->Application->Level->find('list', array('conditions' => array('Level.private' => true))));
	}
	
	public function start()
	{
		$this->layout = 'basic';
	}
	
	public function feedback()
	{
		$this->layout = 'basic';
		$this->set('Application', $this->Session->read('Application'));
		$this->Session->delete('Application');
	}

	public function check()
	{
		$this->layout = 'basic';
	}

	public function next($id)
	{
		$this->Application->id = $id;
		$State = $this->State->get($this->Application->field('status'));
		$State->next($this->Application, $id);
		$this->data = $this->Application->read(null);
		$this->render('ajax/status', 'ajax');
	}
	
	public function reject($id)
	{
		$this->Application->id = $id;
		$State = $this->State->get($this->Application->field('status'));
		$State->reject($this->Application, $id);
		$this->data = $this->Application->read(null);
		$this->render('ajax/status', 'ajax');
	}
	
	public function review()
	{
		if (empty($this->data['Application'])) {
			$this->message('invalid');
			$this->redirect(array('action' => 'check'));
		}
		$id = $this->data['Application']['identifier'];
		$private = $this->Application->get($id, true);
		$public = $this->Application->get($id, false);
		
		$this->layout = 'basic';
		$this->set('private_applications', $private);
		$this->set('public_applications', $public);
		$this->_setCommonOptions();
		$this->set('id', $id);
		// discriminar si son de niveles privados o concertados para mostrar distinta vista
	}
	
	protected function _setCommonOptions() {
		$this->set('levels', $this->Application->Level->find('list'));
	}
	
	
}
?>