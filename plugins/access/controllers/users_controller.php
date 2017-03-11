<?php
class UsersController extends AccessAppController {

	var $name = 'Users';
	var $helpers = array(
		'Uploads.Upload',
		);
	var $components = array(
		'Notify', 
		'Filters.SimpleFilters', 
		'Access.GApi' => array(
			'url' => array('plugin' => 'access', 'controller' => 'users', 'action' => 'gfound')
		));
	
	public function beforeFilter() {
		parent::beforeFilter();
		// $this->Auth->allow('*');
		$this->Auth->allow('logout', 'register', 'confirm', 'forgot', 'recover', 'gregister', 'gauth', 'gfound');
	}


# Google Apps login and register

	public function gauth()
	{
		$value = $this->GApi->request();
		$this->autoRender = false;
	}

	public function gfound()
	{
		$this->GApi->response();
		$user = $this->GApi->user();
		if (!$user) {
			$this->Session->setFlash(__d('access', 'Unable to login with Google Apps.',true), 'flash_error');
			$this->redirect('/');
		}
		$this->User->getActive($user['User']['username']);
		if ($this->User->null()) {
			$this->storeUserDataInSession($user);
            return $this->setAction('gregister', $user);
		}
		$this->loginUser($this->User);
	}
	
	private function storeUserDataInSession($user)
	{
		$this->Session->write('GApps.Register.User', array(
			'username' => $user['User']['username'],
			'email' => $user['User']['email'],
		));
	}

    private function loginUser(User $User)
    {
        $User->connect();
        $this->Auth->login($User->data);
        // $this->Session->write('Auth.User.Role', $userData['Role']);
        $this->redirect($this->Auth->redirect());
    }

/**
 * If GApps login is valid (the visitor has an account in the domain) but it is not registered in the application
 * show a form to complete the profile. This action is allowed if there is a session key GApps.Register.User with
 * valid data, to prevent casual access.
 *
 * @return void
 */
    public function gregister($userData = null)
	{
		$this->layout = 'access';
		// Check if the access to this action is a valid one

		if (!$this->checkValidGoogleAppsRegistrationAttempt($userData)) {
			$this->cakeError('notAllowed', array(
				'url' => $this->here,
				'redirect' => '/'
			));
		}

		// Form processing pass

		if (!empty($this->data)) {
			// Try to register this user, pass userData to perform some checks
			try {
				$this->Session->delete('GApps.Register.User');
				$id = $this->User->gregister($this->data, $userData);
				// If successful registrarion try to login the new user
				$this->User->get($id);
				$this->loginUser($this->User, true);
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage(), 'flash_error');
				$this->redirect('/');
			}
		}

		// Landing pass

		if (empty($this->data)) {
			$this->preloadFormData($userData);
		}
        return $this->render('plugins/access/users/gregister.twig', ['data' => $this->data]);
	}

	private function checkValidGoogleAppsRegistrationAttempt($userData)
	{
		$data = $this->Session->read('GApps.Register.User');

		return $userData['User']['username'] == $data['username'] &&
				$userData['User']['email'] == $data['email'];
	}


# Login and login utility functions

	private function preLoadFormData($userData)
	{
		$this->data['User'] = $userData['User'];
		if (strpos($userData['User']['username'], '.') !== false ) {
			list($fn, $ln) = explode('.', $userData['User']['username']);
			$this->data['User']['realname'] = ucfirst($fn).' '.ucfirst($ln);
		} else {
			$this->data['User']['realname'] = ucfirst($userData['User']['username']);
		}
	}

/**
 * Manages login. This action copies the User roles in the Session and connection status
 * of the user.
 *
 * @return void
 */

	public function login()
	{
		$this->layout = 'access';
		$this->User->getActive($this->Auth->user('username'));
		if (!$this->User->null()) {
			$this->loginUser($this->User);
		}
//		$this->set('available', $this->GApi->available());
        return $this->render('plugins/access/users/login.twig', [
            'available' => $this->GApi->available()
        ]);
	}

/**
 * Manages logout. Stops the connection status of the user and updates last login.
 *
 * @return void
 */
	public function logout() {
		try {
			$this->User->disconnect($this->Auth->user('id'));
			$this->Session->delete('Auth');
			$this->GApi->logout();
			$this->Session->setFlash(__d('access', 'User disconnected.',true), 'flash_error');
		} catch (Exception $e) {
			$this->Session->setFlash(__d('access', 'Invalid or Not Found User.',true), 'flash_error');
		}
		$this->redirect('/');
	}




# CRUD actions

/**
 * Manages index of users to admin
 *
 * @return void
 */
	function index() {
		$this->layout = 'backend';
		$this->paginate['User']['fields'] = array('id', 'username', 'realname', 'email', 'active');
		$this->set('users', $this->paginate()); 
	}

/**
 * Creates a new user. Delegates to edit action. Provided for semantics.
 *
 * @return void
 */
	function add() {
		$this->User->init();
		$this->setAction('edit', $this->User->getID());
	}

/**
 * Edit a User Model providing an id, or creates a new one, if not.
 *
 * @param string $id (if false, creates a new user)
 * @return void
 */

	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['User'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->User->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->User->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['User'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
		$this->_setCommonOptions();
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$fields = array('id', 'username', 'realname', 'email', 'active', 'last_login', 'connected', 'photo', 'bio');
		$this->User->contain(array('Role'));
		if (!($this->data = $this->User->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

    protected function _setCommonOptions()
    {

        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

/**
 * Activates an account. Sends an email to notify user.
 *
 * @param string $id
 * @return void
 */
	public function activate($id) {
		try {
			if ($this->User->activate($id)) {
				$this->Session->setFlash(__d('access', 'Account activated.', true), 'flash_success');
			} else {
				$this->Session->setFlash(__d('access', 'No changes. Account activated yet.', true), 'flash_success');
			}
		} catch (InvalidArgumentException $e) {
			$this->Session->setFlash(__d('access', 'Invalid User or User was active. No account was activated.', true),  'flash_error');
		} catch (Exception $e) {
            $this->Session->setFlash(__d('access', 'Account activated, but I\'ve been unable to send email.', true), 'flash_alert');
		}
		$this->redirect($this->referer());
	}

/**
 * Deactivates an account. Sends an email to notify user.
 *
 * @param string $id
 * @return void
 */
	public function deactivate($id) {
		try {
			if ($this->User->deactivate($id)) {
				$this->Session->setFlash(__d('access', 'Account deactivated.', true), 'flash_success');
			} else {
				$this->Session->setFlash(__d('access', 'No changes. Account deactivated yet.', true), 'flash_success');
			}
		} catch (InvalidArgumentException $e) {
			$this->Session->setFlash(__d('access', 'Invalid User or User was inactive. No account was deactivated.', true),  'flash_error');
		} catch (Exception $e) {
			$this->Session->setFlash(__d('access', 'Account deactivated, but I\'ve been unable to send email.', true), 'flash_alert');
		}
		$this->redirect($this->referer());
	}

    /**
 * Manages new User registration. Takes care of the user data and send and email
 * to confirm if necessary.
 *
 * @return void
     */
	public function register() {
		$this->layout = 'access';
//		if (empty($this->data) || !$this->isRegistrationAllowed()) {
//			$this->redirect('/');
//		}
        if (!empty($this->data)) {
            // $this->User->create();
            try {
                $ticket = $this->User->register($this->data);
                $msg = __d('access', 'The account %s has been created.', true);
                $this->Session->setFlash(sprintf($msg, $this->data['User']['username']), 'flash_success');
                $this->set(compact('ticket'));
                $this->set('user', $this->data['User']);
                $template = Configure::read('Access.registration').'_registration';
                $result = $this->Notify->send(
                    $template,
					$this->data['User']['email'],
					__d('access','Thanks for registering.', true)
					);

                return $this->render('plugins/access/users/'.$template.'.twig');
			} catch (Exception $e) {
				$this->Session->setFlash(__d('access', 'Something went wrong with your account. Please, try again.', true), 'flash_error');
				$this->_resetPasswordErrors();
			}
		}
        $this->layout = false;

        return $this->render('plugins/access/users/register.twig');
	}

    /**
     * Provide a simple way to manage passwords when validation errors happen.
     *
     * If a password validation error happens then reset the password
     * If password is valid, then reset to the plain value in confirm_password
     *
     * @return void
     */
    protected function _resetPasswordErrors()
    {
        if (array_key_exists('password', $this->User->invalidFields())) {
            $this->data['User']['password'] = $this->data['User']['confirm_password'] = '';
        } else {
            $this->data['User']['password'] = $this->data['User']['confirm_password'];
        }
    }

/**
 * Manages second step in the registration process. User arrive here with a ticket
 * attached to a confirm registration method in the Model that activates the User.
 *
 * @param string $ticket
 * @return void
 */
	public function confirm($ticket = null) {
        $this->layout = 'access';

		if (Configure::read('Access.registration') !== 'auto') {
			$this->redirect('/');
			return;
		}

		if (!$ticket || !$this->User->redeemTicket($ticket)) {
			$this->Session->setFlash(__('Invalid or expired ticket.', true),  'flash_error');
			$this->redirect('/');
		}
        return $this->render('plugins/access/users/confirm.twig');
	}

/**
 * Manages first step of password recovery. User arrive here and provide username
 * and/or email, so we can find him in the database and generate a ticket for recover.
 * If we can generate a ticket, we send the user an email with a link to the recover
 * action.
 *
 * @return void
 */
	public function forgot() {
		$this->layout = 'access';
		if (!empty($this->data)) {
			try {
				$this->User->forgot(
                    $this->data['User']['recovery_username'],
					$this->data['User']['recovery_email']
				);
				$this->render('forgot_ticket_sent');
			} catch (OutOfBoundsException $e) {
				$this->Session->setFlash($e->getMessage(), 'flash_error');
				$this->redirect(array('action' => 'forgot'));
			} catch	(Exception $e) {
				$this->Session->setFlash($e->getMessage(), 'flash_error');
				$this->redirect(array('action' => 'forgot'));
			}
		}
        return $this->render('plugins/access/users/forgot.twig');
	}

/**
 * Manages last step of password recovery. User arrives here with a ticket to recover password.
 * We send the generated password by email and notify the user the result of the
 * operation.
 *
 * @param string $ticket
 * @return void
 */
	public function recover($ticket = null) {
		$this->layout = 'access';
		if (!$ticket || !($password = $this->User->redeemTicket($ticket))) {
			$this->Session->setFlash(__('Invalid or expired ticket.', true), 'flash_error');
			$this->redirect(array('action' => 'forgot'));
			return;
		}
		$this->User->read(null);
		$this->set(compact('password'));
		$this->set('user', $this->User->data);
		$result = $this->Notify->send(
			'recover',
			$this->User->data['User']['email'],
			__d('access','Your new password', true)
		);
	}

/**
 * Manages editing of user's profile.
 *
 * @return void
 */
	public function profile() {
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Changes saved to %s \'%s\'.', true), __d('access', 'User', true), $this->data['User']['username']), 'flash_success');
				$this->redirect(array('action' => 'dashboard'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s data could not be saved. Please, try again.', true), __d('access', 'User', true)), 'flash_validation');
				$this->_resetPasswordErrors();
			}
		}
		if (empty($this->data)) {
			$fields = array('id', 'username', 'realname', 'email', 'last_login', 'connected', 'photo', 'bio');
			$this->data = $this->User->read($fields, $this->Auth->user('id'));
		}
	}

    /**
 * Landing page for users in the application. The idea is to have a bunch of modules
 * to inform user of her status.
 *
 * Dashboard are *_dashboard.ctp files in any elements folder
 * $Folder for testing only
 * @return void
     */

	public function dashboard($base = APP) {
		$dashboards = glob($base.'plugins/*/views/elements/dashboards/*.ctp');
		foreach ($dashboards as &$dashboard) {
			$dashboard = preg_replace('/^.*plugins/', '', $dashboard);
			$dashboard = str_replace(array('views'.DS, 'elements'.DS, '.ctp'), '', $dashboard);
		}
        //
		$this->set('dashboards', array_unique($dashboards));
	}

    private function isRegistrationAllowed()
    {
        $registrationMode = Configure::read('Access.registration');

        return in_array($registrationMode, array('auto', 'managed'));
    }

}

?>