<?php
/**
 * GApiComponent
 * 
 * [Short Description]
 *
 * @package access.mh13
 * @author Fran Iglesias
 * @version $Id$
 **/
App::import('Vendor', 'Google_Client', array('file' => 'google-api-php-client/autoload.php'));

class GApiComponent extends Object {

	/**
	 * Array containing the names of components this component uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	var $components = array('Session');
	var $redirectUrl;
	
	var $client = null;
	/**
	 * Called before the Controller::beforeFilter().
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function initialize(&$controller, $settings = array()) {
		if (!isset($this->__settings[$controller->name])) {
			$this->__settings[$controller->name] = $settings;
		}
		$this->redirectUrl = Router::url($settings['url'], true);
		$this->client = new Google_Client();
		$this->client->setAuthConfigFile(APP.'config/google_api.json');
	}
	
	public function request()
	{
		$redirect_uri = $this->redirectUrl;
		
		$this->client->setRedirectUri($redirect_uri);
		$this->client->setScopes('email');
		
		$auth_url = $this->client->createAuthUrl();
		header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
	}
		
	public function response()
	{
		$redirect = $this->redirectUrl;
		
		$this->client->setRedirectUri($redirect);
		$this->client->setScopes('email');
		
		if (isset($_GET['code'])) {
			$this->client->authenticate($_GET['code']);
			$this->Session->write('access_token', $this->client->getAccessToken());
			header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		} 
		
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			$this->client->setAccessToken($_SESSION['access_token']);
		} else {
			$authUrl = $this->client->createAuthUrl();
		}

		if ($this->client->getAccessToken()) {
			$this->Session->write('access_token', $this->client->getAccessToken());
			$token_data = $this->client->verifyIdToken()->getAttributes();
			$this->Session->write('GAuthToken', $token_data);
		}
	}
	
	public function logout()
	{
		$access_token = $this->Session->read('access_token');
		if (empty($access_token)) {
			return true;
		}
		$t = json_decode($access_token);
		$this->Session->delete('access_token');
		$this->client->setRedirectUri(Router::url('/', true));
		return $this->client->revokeToken($t->access_token);
	}
	
	public function user()
	{
		$user_email = $this->Session->read('GAuthToken.payload.email');
		$this->Session->delete('GAuthToken');
		if (empty($user_email)) {
			return false;
		}
		list($user, $domain) = explode('@', $user_email);
		if (!in_array($domain, Configure::read('GApps.domain'))) {
			throw new OutOfBoundsException(__d('access', 'The domain %s is not allowed for this site.', true));
		}
		
		return array('User' => array(
			'identity' => $user_email,
			'username' => $user,
			'email' => $user_email,
			'domain' => $domain
		));
	}
	
	public function available()
	{
		return true;
	}
}
?>