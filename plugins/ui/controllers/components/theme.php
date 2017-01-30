<?php
/**
 * ThemeComponent
 * 
 * [Short Description]
 *
 * @package ui.mh13
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class ThemeComponent extends Object {

	/**
	 * Array containing the names of components this component uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	var $components = array('Session');

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
		// Manages visual Theme
		$this->setControllerTheme($controller, Configure::read('Site.theme'));
		$this->setControllerTheme($controller, $this->Session->read('Channel.theme'));
		$this->load($controller->theme);
		$controller->paginate['limit'] = Configure::read('Theme.limits.page');
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
	
	/**
	 * Asjusts Controller theme settings
	 *
	 * @param string $controller 
	 * @param string $theme 
	 * @return void
	 * @author Fran Iglesias
	 */
	protected function setControllerTheme(&$controller, $theme)
	{
		if (!$theme) {
			return;
		}
		$controller->view = 'Theme';
		$controller->theme = $theme;
	}
	
	/**
	 * Loads default theme settings
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function loadDefaults()
	{
		$path = VIEWS . 'theme_setup.php';
		if (!file_exists($path)) {
			throw new LogicException('A default theme_setup.php file should exist in folder: '.VIEWS);
		}
		include($path);
		Configure::write('Theme', $theme['Theme']);
		return $theme;
	}
	
	public function load($themeName)
	{
		if (!$themeName) {
			return false;
		}
		$default = $this->loadDefaults();
		
		$path = VIEWS . 'themed' . DS . $themeName . DS . 'theme_setup.php';
		if (!file_exists($path)) {
			$this->log('There is not theme_setup.php for '.$themeName, 'error');
			return false;
		}

		include($path);
		$theme['Theme'] = array_merge($default['Theme'], $theme['Theme']);
		Configure::write('Theme', $theme['Theme']);
	}
	
	
}
?>