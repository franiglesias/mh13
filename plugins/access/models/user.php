<?php

/**
 * User
 * 
 * User Model
 *
 * @package access.milhojas
 * @version $Rev$
 * @license MIT License
 * 
 * $Id$
 * 
 * $HeadURL$
 * 
 **/

App::import('Lib', 'PasswordGenerator');
App::import('Model', 'Access.RolesUser');


class User extends AccessAppModel {
	var $name = 'User';
	
	var $displayField = 'username';
	
	var $actsAs = array(
		'Tickets.Ticketable',
		'Access.Ownable' => array('mode' => 'owner'),
		'Uploads.Upable' => array(
			'photo' => array(
				'mode' => 'url',
				'private' => false,
				'imagePostprocess' => array(
					'normalize' => array(
						'width' => 60,
						'height' => 60,
						)
					)
				)
			)
		);

	var $hasAndBelongsToMany = array(
		'Role' => array(
			'className' => 'Access.Role',
			'joinTable' => 'roles_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'role_id',
			'unique' => true,
			'with' => 'RolesUser'
		),
	);
	
	var $hasMany = array(
		'RolesUser' => array(
			'className' => 'Access.RolesUser'
		)
	);

	var $validate = array(
		'username' => array(
			'rule' => 'isUnique',
			'allowEmpty' => false,
			'message' => 'username must be unique'
			),
		'password' => array(
			'rule' => array('match', 'confirm_password', 'sha1', true),
			'message' => 'passwords doesn\'t match',
			'allowEmpty' => true
			),
		'email' => array(
			array(
				'rule' => 'email',
				'allowEmpty' => false,
				'message' => 'invalid email'
				),
			array(
				'rule'  => array('match', 'confirm_email'),
				'message' => 'emails doesn\'t match',
				'on' => 'create'
				)
			),
		'confirm_password' => array(
			'rule' => 'notEmpty',
			'message' => 'confirm password',
			'on' => 'create'
			)
		);

	public function  __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}

	/**
	 * When editing a record, automatically clears password data if any password field is empty.
	 * This is needed when password is not changed in the /access/users/edit action to
	 * avoid overriding with empty password. Validation should manage other situations
	 * (i.e. non matching pwds)
	 */
	public function beforeSave() {
		if ($this->id) {
			// Clear password data if no change is done in the edit form, to avoid overwrite
			if ($this->shouldClearPasswords()) {$this->clearPasswords();}
		}
		return true;
	}
	
		/**
		 * True if at least one of the passwords fields is empty
		 *
		 * @return void
		 * @author Fran Iglesias
		 */
		private function shouldClearPasswords()
		{
			return empty($this->data['User']['confirm_password']) || empty($this->data['User']['password']);
		}
		/**
		 * Clear password fields to avoid overwrites
		 *
		 * @return void
		 * @author Fran Iglesias
		 */
		private function clearPasswords()
		{
			unset($this->data['User']['password']);
			unset($this->data['User']['confirm_password']);
		}

	/**
	 * Prepares a fresh record in the Database and gets an id in this->id
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function init()
	{
		$this->create();
		$this->save(null, false);
	}

	/**
	 * Change active status of user to false.
	 *
	 * @param string $id (optional)
     *
	 * @return boolean true on success | false on no change
	 */
	public function deactivate($id = null) {
		$this->setId($id);
		if (!$this->field('active')) {
			return false;
		}
		if (!$this->saveField('active', 0)) {
			throw new RuntimeException(__('Unable to save data.', true));
		}
		ClassRegistry::getObject('EventManager')->notify($this, 'access.user.deactivate');
		return true;
	}

    /**
 * Confirms a user registration, called from ticketable behavior
 *
 * @return boolean true on success
 **/
	public function confirm($id) {
		if (!$id) {
			throw new InvalidArgumentException(__('A valid ID is needed to perform this model method', true), 1);
		}
		return $this->activate($id);
	}

    /**
     * Change active status of user to true.
     *
     * @param string $id (optional) the user id
     *
     * @return boolean true on success | false on no change
     */
    public function activate($id = null)
    {
        $this->setId($id);
        if ($this->field('active')) {
            return false;
        }
        if (!$this->saveField('active', 1)) {
            throw new RuntimeException(__('Unable to save data.', true));
        }
        ClassRegistry::getObject('EventManager')->notify($this, 'access.user.activate');

        return true;
    }

/**
 * Used in login, sets a timestamp for the user to flag it as connected
 *
 * @param string $id
 *
 * @return string the date
 */	
	public function connect($id = null)	{
		$this->setId($id);
		$date = date('Y-m-d H:i:s');
		if (!$this->saveField('connected', $date)) {
			throw new RuntimeException('Unable to save data');
		}
		ClassRegistry::getObject('EventManager')->notify($this, 'access.user.login');
		return $date;
	}

/**
 * Used in logout, clears the connected timestamp and copies it into the last_login
 * field, so you have info to select items for a user based on date
 *
 * @return void
 **/
	public function disconnect($id = null) {
		$this->setId($id);
		$lastLogin = $this->field('connected');
		$this->set(array(
			'connected' => null,
			'last_login' => $lastLogin
		));
		if (!$this->save(null, false)) {
			throw new RuntimeException('Unable to save data');
		}
		ClassRegistry::getObject('EventManager')->notify($this, 'access.user.logout');
		return true;
	}

	public function isConnected($id = null) {
		$this->setId($id);
		$result = $this->field('connected');
		return $result != false;
	}
	
/**
 * Creates a new user with some data
 *
 * @param array  $registrationData
 *	User.username
 *	User.password
 *  User.confirm_password
 *  User.realname
 *  User.email
 * @param string $defaultGroupId
 *
 * @return string A ticket
 */
	public function register($registrationData = array()) {
		if (!$registrationData) {
			throw new InvalidArgumentException(__('Empty registration data for Register.', true));
		}
		$registrationData['User']['active'] = 0;
		$this->add($registrationData);
		return $this->createTicket('confirm', $this->id);
	}

    /**
     * Creates a new User record with data
     *
     * @param string $registerData
     *
     * @return void
     * @author Fran Iglesias
     */
    public function add($registerData)
    {
        $this->create();
        $this->set($registerData);
        if (!$this->save()) {
            throw new Exception(__('Unable to create Account.', true));
        }
        // Attach user to default role
        ClassRegistry::getObject('EventManager')->notify($this, 'access.user.register');
    }
	
/**
 * Custom method to register a new user logged with its GApps account
 *
 * @param array $registrationData User data record
 * @param array $check keys 'user' and 'user_email' to force a check to avoid forging
 * @return mixed User id if registration succeeded or false if there were an error
 */
	public function gregister($registrationData = array(), $check) {
		if (!$registrationData || !$check) {
			throw new InvalidArgumentException(__('Empty registration data for GRegister.', true));
		}
		if (!$this->isValidRegistration($registrationData, $check)) {
			throw new UnexpectedValueException(__('Username and/or email probably forged or invalid.', true));
		}
		if ($this->isRegistered($registrationData['User']['username'])) {
			throw new InvalidArgumentException(__('User exists.', true));
		}

		$registrationData['User']['active'] = 1;
		$registrationData['User']['confirm_email'] = $registrationData['User']['email'];
		$registrationData['User']['confirm_password'] = PasswordGenerator::readable();
		$registrationData['User']['password'] = Security::hash($registrationData['User']['confirm_password'], 'sha1', true);
		$this->add($registrationData);
		return $this->id;
	}
	
	private function isValidRegistration($registrationData, $check)
	{
		return $registrationData['User']['username'] == $check['User']['username'] && 
			$registrationData['User']['email'] == $check['User']['email'];
	}

    /**
     * Checks if a user is registered
     *
     * @param string $username
     *
     * @return boolean
     * @author Fran Iglesias
     */

    public function isRegistered($username)
    {
        $user = $this->find(
            'count',
            array(
                'conditions' => array(
                    'username' => $username,
                ),
            )
        );

        return !empty($user);
    }

/**
 * Locates the user referenced by username and/or email. User must be in active status.
 * If found creates a ticket binded to the recover method, when the ticket is redeemed,
 * a new password is generated and returned to the controller to send via Notify->send
 *
 * @param string $username
 * @param string $email
 *
 * @return void
 */
	public function forgot($username = false, $email = false) {
		if (!$username && !$email) {
			throw new InvalidArgumentException(__('Not enough data', true));
		}
		$this->locate($username, $email);
		$ticket = $this->createTicket('recover', $this->id);
		if (!$ticket) {
			throw new RuntimeException(__d('access', 'Unable to get a ticket to recover password.', true));
		}
		$this->keepTicket($ticket);
		ClassRegistry::getObject('EventManager')->notify($this, 'access.user.forgot');
		return $ticket;
	}

	private function locate($username, $email)
	{
		$conditions['active'] = true; // User should be active to recover passwords
		if ($username) {
			$conditions['username'] = $username;
		}
		if ($email) {
			$conditions['email'] = $email;
		}
		$user = $this->find('all', compact('conditions'));
		if (!$user or count($user) > 1) {
			throw new OutOfBoundsException(__d('access', 'Unable to found a valid User with the data provided.', true));
		}
		$user = array_shift($user);
		$this->id = $user['User']['id'];
	}

/**
 * Generates and returns a new password for the user
 *
 * @param string $id
 *
 * @return void
 */
	public function recover($id = false) {
		$this->setId($id);
		$password = PasswordGenerator::readable();
		$hash = Security::hash($password, 'sha1', true);
		$this->saveField('password', $hash, array('validate' => false, 'callbacks' => false));
		return $password;
	}

	public function get($id = null)
	{
		$this->setId($id);
		$data = $this->find('first', array(
			'conditions' => array('User.id' => $id),
			'contain' => 'Role'
		));
		$this->data = $data;
		return $data;
	}

    /**
	 * Retrieves a User by username and active state
     *
     * @param string $userName
     *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function findActiveByUsername($userName)
	{
		$this->contain('Role');
		return $this->getActive($userName);
	}
	
	/**
	 * Retrieves a User by User name if is active
     *
     * @param string $userName
     *
	 * @return array
	 * @author Fran Iglesias
	 */
	public function getActive($userName)
	{
		$user = $this->find('first', array(
			'conditions' => array(
				'username' => $userName,
				'active' => true
			)
		));
		$this->data = $user;
		$this->id = $user['User']['id'];
		return $user;
	}
	
	public function attach(Role $Role)
	{
		ClassRegistry::init('RolesUser')->attach($this, $Role);
	}
	
	public function attached(Role $Role)
	{
		return ClassRegistry::init('RolesUser')->attached($this, $Role);
	}
	
	public function getName()
	{
		if ($this->null()) {
			return false;
		}
		return $this->data['User']['username'];
	}
	
	public function listWithRole(Role $Role)
	{
		return ClassRegistry::init('RolesUser')->usersWithRole($Role);
	}
}
?>
