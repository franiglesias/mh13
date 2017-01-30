<?php
class ResumesController extends ResumesAppController {

	var $name = 'Resumes';
	
	var $requireLogin = array('modify', 'remove', 'preview', 'changepwd');
	
	var $layout = 'resumes';
	
	var $helpers = array('Resumes.Resume');
	
	var $components = array('Notify', 'Menus.Panels', 'Filters.SimpleFilters');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array('login', 'modify', 'remove', 'create', 'home', 'logout', 'preview', 'changepwd', 'forgot', 'recover'));
		$this->_requireLogin();
	}
	
	public function _requireLogin()
	{
		if (!in_array($this->action, $this->requireLogin)) {
			return true;
		}
		if ($visitor = $this->Session->read('Resume.Auth.id')) {
			return true;
		}
		$this->Session->write('Resume.Auth.redirect', $this->action);
		$this->setAction('login');
	}

/**
 * Visitor registers and create a new resume
 *
 * @return void
 */

	public function create($legal = false)
	{
		$this->saveReferer();
		if (!empty($this->data['Resume'])) {
			$this->Resume->create();
			if ($this->Resume->save($this->data)) {
				$this->message('success');
				$this->Session->write('Resume.Auth', $this->Resume->identifier());
				ClassRegistry::getObject('EventManager')->notify($this->Resume, 'resumes.resume.new');
				$this->redirect(array('action' => 'home'));
			} else {
				$this->message('validation');
			}
		}
		
		if ($legal) {
			$this->setAction('confirm');
		}
		
	}
	
	
	public function confirm()
	{
		$acceptUrl = array('action' => 'create');
		$cancelUrl = array('action' => 'home');
		$this->set(compact('acceptUrl', 'cancelUrl'));
	}
	
	public function login()
	{
		if (!empty($this->data)) {
			// Find resume
			$resume = $this->Resume->authorized($this->data);
			if (empty($resume)) {
				// Failed
				$this->Session->setFlash(__d('resumes', 'There is no resume registered with that email.', true), 'flash_error');
				$this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
			}
			// Retrieve redirect data, beacause next instruction overwrites it
			$redirectTo = $this->Session->read('Resume.Auth.Redirect');
			// Store Resume.Auth data in Session
			$this->Session->write('Resume.Auth', $resume['Resume']);
			// Redirect to original action id needed, if not go to resume home page
			if ($redirectTo) {
				$this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => $redirectTo));
			} else {
				$this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
			}
		}
		
	}
	
	public function logout()
	{
		$this->Session->delete('Resume.Auth');
		$this->Session->setFlash(__d('resumes', 'Googbye!', true), 'flash_success');
		$this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
	}
	
	public function modify()
	{
		if (!empty($this->data)) {
			$this->Resume->create();
			if ($this->Resume->save($this->data)) {
				$this->Session->setFlash(__d('resumes', 'Changes has been applied.', true),'flash_success');
				$this->xredirect();
			} else {
				$this->Session->setFlash(__d('resumes', 'Data could not be saved.', true), 'flash_validation');
			}
		}
		if (empty($this->data)) {
			$id = $this->Session->read('Resume.Auth.id');
			$fields = array('id', 'firstname', 'lastname', 'email', 'introduction', 'phone', 'mobile', 'photo');
			$this->data = $this->Resume->read(null, $id);
			$this->saveReferer();
		}
		$this->set('positions', $this->Resume->Position->find('list'));
	}
	
	public function changepwd()
	{
		if (!empty($this->data)) {
			$this->Resume->create();
			if ($this->Resume->save($this->data)) {
				$this->Session->setFlash(__d('resumes', 'Changes has been applied.', true), 'flash_success');
				$this->xredirect();
			} else {
				$this->Session->setFlash(__d('resumes', 'Data could not be saved.', true), 'flash_validation');
			}
		}
		if (empty($this->data)) {
			$id = $this->Session->read('Resume.Auth.id');
			$this->data['Resume']['id'] = $id;
			$this->saveReferer();
		}
		
	}
	
	public function remove()
	{
		if (!empty($this->data)) {
			if (!empty($this->data['Resume']['delete'])) {
				$this->Resume->delete($this->data['Resume']['id'], true);
				$this->Session->delete('Resume.Auth');
				$this->Session->setFlash(__d('resumes', 'Your data has been permanently removed.', true), 'flash_success');
			} else {
				$this->Session->setFlash(__d('resumes', 'You selected not to remove you data.', true), 'flash_success');
			}
			$this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
		}
		$this->data['Resume']['id'] = $this->Session->read('Resume.Auth.id');
		
	}
	
	public function home()
	{
		$visitor = $this->Session->read('Resume.Auth');
		if (!empty($visitor['id'])) {
			$completedProfile = $this->Resume->isComplete($visitor['id']);
			$stats = $this->Resume->stats($visitor['id']);
			$this->set(compact('visitor', 'completedProfile', 'stats'));
		} else {
			$this->set(compact('visitor'));
		}
		
	}

	public function preview()
	{
		$id = $this->Session->read('Resume.Auth.id');
		$this->_setTypesList();
		$this->set('resume', $this->Resume->readCV($id));
	}


/**
 * Manages first step of password recovery. User arrive here and provide username
 * and/or email, so we can find him in the database and generate a ticker for recover.
 * If we can generate a ticket, we send the user a email with a link to the recover
 * action.
 *
 * @return void
 */
	public function forgot() {
		// $this->layout = 'access';
		if (!empty($this->data)) {
			try {
				$ticket = $this->Resume->forgot(
					$this->data['Resume']['recovery_email']
				);
				$this->set(compact('ticket'));
				$this->set('resume', $this->Resume->read('*'));
				$result = $this->Notify->send(
					'resumes_forgot',
					$this->data['Resume']['recovery_email'],
					__d('access','Recover your lost password.', true)
				);
				$this->render('forgot_ticket_sent');
			} catch (InvalidArgumentException $e) {
				$this->Session->setFlash(__d('resumes', 'Email unknown.', true), 'flash_error');
				$this->redirect(array('action' => 'forgot'));
			} catch	(Exception $e) {
				$this->Session->setFlash($e->getMessage(), 'flash_error');
				$this->redirect(array('action' => 'forgot'));
			}
		}
	}

/**
 * Manages last step of password recovery. User arrive here with a ticket to recover password.
 * We send the generated password by email and notify the user the result of the
 * operation.
 *
 * @param string $ticket 
 * @return void
 */	
	public function recover($ticket = null) {
		// $this->layout = 'access';
		if (!$ticket || !($password = $this->Resume->redeemTicket($ticket))) {
			$this->Session->setFlash(__('Invalid or expired ticket.', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->Resume->read('*');
		$this->set(compact('password'));
		$this->set('resume', $this->Resume->data);
		$result = $this->Notify->send(
			'resumes_recover',
			$this->Resume->data['Resume']['email'],
			__d('access','Your new password', true)
		);
	}
	

/* Administrative methods */ 

	public function index() {
		$this->layout = 'backend';
		if ($merit = $this->SimpleFilters->getFilter('Merit.title')) {
			$this->paginate['Resume'][0] = 'search';
			$this->paginate['Resume']['terms'] = $merit;
			unset($this->paginate['Resume']['conditions']['Merit.title LIKE']);
		}
		$this->set('resumes', $this->paginate());
	}

	public function view($id = null) {
		$this->layout = 'backend';
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), 'resume'));
			$this->redirect(array('action' => 'index'));
		}
		$this->_setTypesList();
		$this->set('resume', $this->Resume->readCV($id));
	}
	
	public function search()
	{
		$this->layout = 'backend';
		if (!empty($this->data['Resume'])) {
			$this->paginate['Resume'][0] = 'search';
			$this->paginate['Resume']['terms'] = $this->data['Resume']['terms'];
			$this->set('resumes', $this->paginate('Resume'));
			$this->render('index');
		}
	}


/**/

	
	protected function _setTypesList()
	{
		App::import('Model', 'Resumes.MeritType');
		$MT = ClassRegistry::init('MeritType');
		$types = $MT->find('all');
		$this->set('types', $types);
	}
	
}
?>