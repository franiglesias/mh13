<?php

/**
* 
*/

App::import('Core', 'Security');
App::import('Vendor', 'AppShell');

class MhShell extends AppShell
{
	var $uses = array(
		'Access.User', 
		'Menus.Menu',
		'Menus.Bar',
		'Contents.Channel'
		);
		
	var $user_id;
	var $data = array();
	var $tasks = array(
		'Constants', 
		);
	var $newSite = false; // Will store key name of the default site
	var $panels = array(
		'ContentsPanel', 
		'AdminPanel'
		);
		
	var $found = array();

	public function initialize()
	{
		parent::initialize();
	}

	protected function _loadPluginTasks($suffix)
	{
		$uSuffix = Inflector::underscore($suffix);
		$this->out('Loading Tasks of type '.$suffix);
		$Folder = new Folder(APP);
		$tasks = $Folder->findRecursive('.*'.$uSuffix.'\.php$');
		$this->out('Found '.count($tasks).' task(s)');
		$this->found[$suffix] = array();
		foreach ($tasks as $task) {
			$name = preg_replace("/\.[^$]*/","",basename($task));
			$name = Inflector::classify($name);
			$this->out('... Adding task: '.$name);
			$this->tasks[] = $this->found[$suffix][] = $name;
		}
		$this->loadTasks();
		$this->out('Tasks loaded.');
	}


	public function createBackendMenu()
	{
		$this->out('Creating Backend Menu');
		$this->hr();
		$this->_loadPluginTasks('BackendMenu');
		foreach ($this->found['BackendMenu'] as $backendMenu) {
			$this->out('Resetting '.str_replace('BackendMenu', '', $backendMenu));
			$this->$backendMenu->execute();
		}
		$this->hr();
	}
	
	function main()
	{

		
	}

	public function test() {
		$this->writeConfigFile();
	}
	
	public function install()
	{
		$this->out('Milhojas installation');
		$this->hr();
		$this->confirm('This operation will erase all your actual data. Should I continue?');
		// Resseting data tables
		$this->out('Reset System');
		$this->hr();
		$this->_resetPermissions();
		$this->_resetRoles();
		$this->_resetUsers();
		$this->_resetMenus();
		$this->hr();
		$this->createBasicRoles();
		$this->createRootUser();
		$this->createBasicMenus();
		$this->createPanels();
		$this->out('Creating configuration file...');
		$this->writeConfigFile();
		$this->initContents();
	}

/**
 * Reset and initiate content system, creates a default Channel and Site, associates
 * root user to default Channel as owner, and associates Channel and Site. Names
 * of Channel and Site are taken from global Site name as stated in configuration
 * file.
 *
 * @return void
 */	
	public function initContents() 
	{
		$this->out('Initializing Contents Module...');
		$this->hr();
		
		$path = APP.'config'.DS.'mh13.php';
		if (!file_exists($path)) {
			$this->error('Configuration file '.$path.' doesn\'t exist');
		}
		
		$this->out('    Creating Default Channel and binding root user as owner.');
		$this->Channel->install($this->user_id);
		
		$this->out('    Creating Default Site and auto attaching channel.');
		App::import('Model', 'Contents.Site');
		$this->newSite = ClassRegistry::init('Site')->install();
		if (!$this->newSite) {
			$this->error('Default Site could not be created.');
		}
		$this->hr();
	}

/**
 * Creates a root User. The action prompts the user to provide data in order to create
 * the account. User is assigned to default role root, which grants privileges to
 * access all URLs in the application (but not to contents created by another users
 * if not explicitly associated to a channel or item)
 *
 * @return void
 */	
	public function createRootUser()
	{
		$this->out('Creating the first user (root privileged)...');
		$this->hr();
		$username = $this->inParam('user', 'Set the name for root user');
		$password = $this->inParam('pass', 'Now, provide a password for root user ('.$username.')');
		$realname = $this->inParam('real', 'What is '.$username.'\'s Real Name');
		$email = $this->inParam('email', 'Finally, an email to contact '.$username);
		$data = array(
			'User' => array(
				'username' => $username,
				'password' => Security::hash($password, 'sha1', true),
				'realname' => $realname,
				'email' => $email,
				'active' => 1
				)
			);
		$this->User->create();
		$result = $this->User->save($data, false);
		if ($result) {
			$this->out(sprintf('>>> User %s created, with password %s', $username, $password));
		} else {
			$this->err('Problem! User has not been created');
		}
		$this->user_id = $this->User->id;
		$this->User->setRole('root');
		$this->hr();
	}	

/**
 * Batch creation of a given number accounts in the form prefix-01 to prefix-99.
 * Optionally, can bind the users to a channel with a role
 *
 * @return void
 */	
	public function accounts()
	{
		$prefix = $this->inParam('prefix', 'Please, provide a prefix for this accounts', 'user');
		$number = $this->inParam('number', 'Please, provide the total number of accounts desired', '10');
		$role = $this->inParam('role', 'A role to this new accounts', 'user');
		$channel = $this->in('Channel to associate these accounts');
		$channelRole = $this->in('Role in the Channel for these accounts', array('E' => 'editor', 'A' => 'author', 'C' => 'contributor') , 'contributor');
		
		App::import('Lib', 'PasswordGenerator');
		$pg = new PasswordGenerator();
		for ($i=1; $i <= $number; $i++) { 
			$password = $pg->readable();
			$username = $prefix .'-'. str_pad($i, 2, '0', STR_PAD_LEFT);
			$data = array(
			'User' => array(
				'username' => $username,
				'password' => Security::hash($password, 'sha1', true),
				'realname' => $username,
				'email' => false,
				'active' => 1
				)
			);
			$this->User->create();
			$result = $this->User->save($data, false);
			if ($result) {
				$this->out(sprintf('User: %s  Password: %s', $username, $password));
			} else {
				$this->err(sprintf('User: %s could not be created.', $username));
			}
			$this->User->setRole('user');
			if (!empty($role)) {
				$this->User->setRole($role);
			}
			
			// Associate users to a channel with a role
			if ($channel) {
				$channel_id = $this->Channel->idFromSlug($channel);
				$this->Channel->bindUser($this->User->id, $channelRole, $channel_id);
			}
		}
		$this->out('End of Process.');
	}

/**
 * Reset and initiates the basic role system with four kind of roles:
 * 
 * root: full access
 * user: minimum access to login into the system
 * blogger: user that can write contents
 * blogmaster: user that can create and manage channels
 *
 * @return void
 */	
	public function createBasicRoles()
	{
		$this->out('Creating Basic Roles');
		$this->hr();
		
		App::import('Model', 'Access.Role');
		$Role = ClassRegistry::init('Role');
		
		$Role->createDefaultRoles();
		
		ClassRegistry::flush('Role');
		unset($Role);
		
		$this->hr();
	}


/**
 * Reset permission system, clearing Permission and Ownership models
 *
 * @return void
 */
	protected function _resetPermissions()
	{
		$this->out('    Resetting Permission and Ownership System...');
		$this->User->Role->Permission->deleteAll('1=1');
		$this->User->Owns->deleteAll('1=1');
	}


/**
 * Reset users system, clearing users table
 *
 * @return void
 */
	protected function _resetUsers()
	{
		$this->out('    Resetting Users...');
		$this->User->deleteAll('1=1');
	}

/**
 * Reset roles system, clearing Roles tables
 *
 * @return void
 */
	protected function _resetRoles()
	{
		$this->out('    Resetting Role System...');		
		$this->User->Role->deleteAll('1=1');
	}
	
	protected function _resetMenus() {
		$this->out('    Resetting Menu System...');
		$this->Menu->deleteAll('1=1');
	}
	
	function createBasicMenus() {
		$this->out('Initializing Menu System');
		$this->hr();
		// Basic Menu
		$globalMenu = array(
			'Menu' => array(
				'title' => 'global',
				),
			'MenuItem' => array(
				array(
					'label' => 'Home',
					'url' => '/',
					'order' => 0
					),
				array(
					'label' => 'Aggregator',
					'url' => '/aggregator/entries',
					'order' => 2
					),
				array(
					'label' => 'Channels',
					'url' => '/contents/channels/menu',
					'order' => 1
					),
				
				)
			);
		$this->Menu->create();
		$this->Menu->saveAll($globalMenu);
		// Backend Menu
		$backendMenu = array(
			'Menu' => array(
				'title' => 'backend',
				),
			'MenuItem' => array(
				array(
					'label' => 'Administrator',
					'url' => '/access/access/index',
					'order' => 5,
					'access' => 2
					),
				array(
					'label' => 'Contents',
					'url' => '/contents/contents/index',
					'order' => 30,
					'access' => 2
					),
				array(
					'label' => 'Dashboard',
					'url' => '/access/users/dashboard',
					'order' => 0,
					'access' => 1
					),
				array(
					'label' => 'Profile',
					'url' => '/access/users/profile',
					'order' => 70,
					'access' => 1
					)
				)
			);
		
		$this->Menu->create();
		$this->Menu->saveAll($backendMenu);
		$this->hr();
	}

/**
 * The following actions prompt the user to provide data to create configuration
 * file. Some configuration data are automatically created here for consistency
 *
 * @return void
 */
	
	public function getSite() {
		$this->data['Site']['title'] = $this->required('Name for the site');
		$this->data['Site']['tagline'] = $this->required('Tagline or brief description');
		$this->data['Site']['description'] = $this->required('Long description for the site');
		$this->data['Site']['icon'] = $this->in('Logo file (will be in img directory)',null, 'logo.png');
		$this->data['Site']['theme'] = $this->in('Visual theme',null, 'basic');
		$this->data['Site']['author'] = $this->in('Author');
		// $this->data['Site']['showInHome'] = Inflector::slug($this->data['Site']['title'], '_');
		// $this->data['Site']['planetHome'] = Inflector::slug($this->data['Site']['title'], '_');
	}
	
	public function getOrganization()
	{
		$this->data['Organization']['title'] = $this->in('Organization');
		$this->data['Organization']['address'] = $this->in('Address');
		$this->data['Organization']['city'] = $this->in('City');
		$this->data['Organization']['state'] = $this->in('State');
		$this->data['Organization']['zip'] = $this->in('Zip Code');
		$this->data['Organization']['email'] = $this->in('email');
		
	}
	
	public function getLanguage() {
		$this->data['Config']['language'] = $this->required('Default Language', null, $this->language());
		$this->data['Config']['languages'] = $this->multi('Languages supported (q to end)', $this->language());
		$this->data['Config']['languages'][] = $this->data['Config']['language'];
	}
	
	public function getSMTP() {
		$transports = array('smtp' => 25, 'ssl' => 465, 'tls' => 465);
		$this->data['Smtp']['type'] = $this->in('SMTP Type', array_keys($transports));
		$this->data['Smtp']['host'] = $this->in('SMTP Host');
		$this->data['Smtp']['port'] = $this->in('SMTP Port', null, $transports[$this->data['Smtp']['type']]);
		$this->data['Smtp']['username'] = $this->in('SMTP User');
		$this->data['Smtp']['password'] = $this->in('SMTP Password');
		$this->data['Mail']['from'] = $this->in('Send messages from email');
		$this->data['Mail']['replyTo'] = $this->in('Reply address', null, 'no-reply@example.com');
	}
	
	public function getOther() {
		$this->data['Access']['registration'] = $this->in('Users can register themselves in the site', array('no', 'managed', 'auto'), 'auto');
		$this->data['GApps']['domain'] = $this->in('Domain if you want to support GApps registration', false, false);
		$this->data['Analytics']['id'] = $this->in('ID following code for Google Analytics', false, false);
		
		$this->data['Analytics']['domain'] = $this->in('Domain to follow with Google Analytics', false, false);
	}
	
	public function getUploads()
	{
		$this->data['Uploads']['tmp'] = $this->in('File system path to temporary store uploaded files', false, WWW_ROOT.'inbox'.DS);
		$this->data['Uploads']['private'] = $this->in('File system path to store files out of the webroot', false, WWW_ROOT.'private'.DS);
		$this->data['Uploads']['normalize'] = array('method' => 'reduce', 'width' => '1024', 'height' => '768');
	}


/**
 * Writes the config file, with the data got from the user
 *
 * @return void
 */
	public function writeConfigFile() {
		$path = APP.'config'.DS.'mh13.php';
		
		$methods = get_class_methods($this);
		foreach ($methods as $method) {
			if (!preg_match('/^get/', $method)) {
				continue;
			}
			$this->$method();
		}
		
		$lines[] = '<?php';
		$lines[] = '';
		$lines[] = '/* --------------------------- */';
		$lines[] = '/* Milhojas configuration file */';
		$lines[] = '/* --------------------------- */';
		$lines[] = '';
		$lines[] = '/* Generated: '.date('Y-m-d H:i:s').' */';
		
		foreach ($this->data as $key => $subkeys) {
			$lines[] = '';
			$lines[] = sprintf('/* %s configuration */', $key);
			$lines[] = '';
			if (is_array($subkeys)) {
				foreach ($subkeys as $subkey => $value) {
					if (empty($value)) {
						$lines[] = chr(9)."\$config['$key']['$subkey'] = null;";
						continue;
					}
					if (is_array($value)) {
						$value = "array('".implode("', '", $value)."')";
						$lines[] = chr(9)."\$config['$key']['$subkey'] = $value;";
						continue;
					} 
					$lines[] = chr(9)."\$config['$key']['$subkey'] = '$value';";
				}
			} else {
				$lines[] = chr(9)."\$config['$key'] = '$subkey';";
			}
		}
		
		// Automatic default configuration. User can change after creation
		$lines[] = '';
		$lines[] = '?>';
		
		$contents = implode(chr(10), $lines);
		
		$this->createFile($path, $contents);
	}
	
	public function createPanels()
	{
		foreach ($this->panels as $panel) {
			$this->_initPanel($panel);
		}
	}
	
	protected function _initPanel($panel)
	{
		$this->$panel->args[] = 'reset';
		$this->$panel->execute();
	}



	protected function __createBackendMenuBar()
	{
		$bar = array(
			'Bar' => array(
				'backend',
				'Menu bar for backend'
			)
		);
		
		$this->Bar->create();
		return $this->Bar->save($bar);
	}
	
	protected function __addMenuToBar($menu, $bar)
	{
		# code...
	}
}


?>