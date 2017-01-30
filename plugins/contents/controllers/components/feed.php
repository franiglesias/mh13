<?php
/**
 * FeedComponent
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class FeedComponent extends Object {

	/**
	 * Array containing the names of components this component uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	var $components = array();

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
	}

	/**
	 * Called after the Controller::beforeFilter() and before the controller action
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function startup(&$controller) {
	}

	/**
	 * Called after the Controller::beforeRender(), after the view class is loaded, and before the
	 * Controller::render()
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 */
	function beforeRender(&$controller) {
	}

	/**
	 * Called after Controller::render() and before the output is printed to the browser.
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 */
	function shutdown(&$controller) {
	}

	/**
	 * Called before Controller::redirect()
	 *
	 * @param object  A reference to the controller
	 * @param mixed  A string or array containing the redirect location
	 * @access public
	 */
	function beforeRedirect(&$controller, $url, $status = null, $exit = true) {
	}
	
	public function channel(&$controller)
	{
		$theChannel = $controller->Item->Channel->find('first', array(
			'conditions' => array('I18n__slug.content' => $controller->params['named']['channel']), 
		));
		$controller->paginate['Item']['channelList'] = $theChannel['Channel']['id'];
		$controller->set(
			'channel',
			array(
				'title' => $theChannel['Channel']['title'],
				'description' => $theChannel['Channel']['description'],
				'link' => Router::url(array('plugin' => 'contents', 'controller' => 'channels', 'action' => 'view', $theChannel['Channel']['slug']), true)
			)
		);
	}
	
	public function site(&$controller)
	{
		App::import('Model', 'Contents.Site');
		$site = ClassRegistry::init('Site')->find('first', array(
			'conditions' => array('Site.key' => $controller->params['named']['site'])
		));
		$controller->paginate['Item']['siteName'] = $site['Site']['key'];
		$controller->set('channel', array(
			'title' => $site['Site']['title'],
			'description' => $site['Site']['description'],
			'link' => Router::url(array('plugin' => 'contents', 'controller' => 'sites', 'action' => 'view', $site['Site']['key']))
		));

	}
	
	public function full(&$controller)
	{
		$controller->set(
			'channel',
			array(
				'title' => Configure::read('Site.title'),
				'description' => Configure::read('Site.description'),
				'link' => Router::url('/', true)
				)
			);
		$controller->paginate['Item']['excludePrivate'] = true;
	}
}
?>