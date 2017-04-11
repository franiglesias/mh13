<?php
/**
 * AjaxRequestComponent
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class AjaxRequestComponent extends Object {

	/**
	 * Array containing the names of components this component uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	var $components = array();
	var $Controller;

	/**
	 * Called before the Controller::beforeFilter().
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function initialize(&$controller, $settings = array()) {
		$this->Controller = $controller;
	}

	/**
	 * Retrieves a param from Controller->params['url'] array. These params are url query params
	 * sent by ajax requests
	 *
     * @param string $key
     *
	 * @return the value of the param or null if not present in the url query
	 * @author Fran Iglesias
	 */
	public function getParam($key)
	{
		if (!empty($this->Controller->params['url'][$key])) {
			return $this->Controller->params['url'][$key];
		}
		return null;
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
}
?>
