<?php
/**
 * StateComponent
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Lib', 'fi_states/StateFactory');


class StateComponent extends Object {

	/**
	 * Array containing the names of components this component uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	var $components = array();
	var $__settings;
	var $Controller;
	var $StateFactory;

	/**
	 * Called before the Controller::beforeFilter().
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	public function initialize(&$controller, $settings = array()) {
		if (!isset($this->__settings[$controller->name])) {
			$this->__settings[$controller->name] = $settings;
		}
		$this->Controller = $controller;
		$this->StateFactory = new StateFactory();
		$this->prepareFactory();
	}
	
	private function prepareFactory()
	{
		$key = key($this->__settings[$this->Controller->name]);
		foreach ($this->__settings[$this->Controller->name][$key] as $status => $stateClass) {
			App::import('Lib', $this->Controller->plugin.'.'.$stateClass);
			$this->StateFactory->set($key, $status, $stateClass);
		}
	}

	public function get($status)
	{
		$key = key($this->__settings[$this->Controller->name]);
		return $this->StateFactory->get($key, $status);
	}

}
?>