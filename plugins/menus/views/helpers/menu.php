<?php
/**
 * MenuItemHelper
 * 
 * [Short Description]
 *
 * @package menus.mh13
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Colegio Miralba
 **/
App::import('Helper', 'SinglePresentationModel');

class MenuHelper extends SinglePresentationModelHelper {

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Menus.MenuItem', 'Menus.MenuItems');
	var $model = false;
	
	var	$classes = array(
		'nav' => 'top-bar',
		'section' => 'top-bar-section',
		'dropdown' => 'dropdown',
		'has-dropdown' => 'has-dropdown'
	);
	
	var $defaults = array(
		'search' => false,
		'classes' => array(
			'nav' => 'top-bar',
			'section' => 'top-bar-section',
			'dropdown' => 'dropdown',
			'has-dropdown' => 'has-dropdown'
		)
	);
	
	
	public function render()
	{
		if ($this->isEmpty()) {
			return '';
		}
		$this->useModel('Menu');
		if ($this->countKey('MenuItem')) {
			return $this->Html->tag('li', $this->buildLink().$this->buildMenuItemsList($this->classes['dropdown']), array('class' => $this->classes['has-dropdown']));
		}
		return $this->Html->tag('li', $this->buildLink());
	}
	
	public function put($menuTitle, $class = 'mh-menu')
	{
		$this->load($menuTitle);
		return $this->plain($class);
	}
	
	
	public function plain($class = 'mh-menu')
	{
		if ($this->isEmpty()) {
			return '';
		}
		$this->useModel('Menu');
		if ($this->countKey('MenuItem')) {
			return $this->buildMenuItemsList($class);
		}
		return $this->Html->tag('li', $this->buildLink());
	}
	
	public function topbar($id, $showTitle = false)
	{
		$this->loadById($id);
		$section = $this->Html->tag('section', $this->buildMenuItemsList(), 'top-bar-section');
		$code = $this->Html->tag('div', $this->topbarTitle($showTitle).$section);
		return $this->Html->tag('nav', $code, array('class' => 'top-bar', 'data-topbar'));
	}
	
	public function topbarTitle($label)
	{
		if (!$label) {
			return false;
		}
		return $this->Html->tag(
			'ul', 
			$this->Html->tag('li', $this->Html->tag('h1', $label), 'name').
			$this->menuToggle(__d('menus', 'Menu', true)), 
			'title-area'
		);
	}
	
	public function menuToggle($label = 'Menu')
	{
		return $this->Html->tag('li', $this->nowhereLink($this->Html->tag('span', $label)), 'toggle-topbar menu-icon');
	}
	
	private function nowhereLink($label)
	{
		return $this->Html->link($label, '#', array('escape' => false));
	}

	
	public function load($menuTitle)
	{
		$data = $this->requestAction(
			array('plugin' => 'menus',
			'controller' => 'menus',
			'action' => 'items'
			),
			array('pass' => array($menuTitle))
		);
		$this->bind($data);
	}
	
	public function loadById($id)
	{
		$data = $this->requestAction(
			array('plugin' => 'menus',
			'controller' => 'menus',
			'action' => 'menu'
			),
			array('pass' => array($id))
		);
		$this->bind($data);
	}
	
		
	private function buildMenuItemsList($class = 'mh-menu')
	{
		$code = '';
		$data = $this->DataProvider->dataSet();
		if (empty($data['MenuItem'])) {
			return false;
		}
		foreach ($data['MenuItem'] as $menuItem) {
			$code .= $this->MenuItem->bind($menuItem)->render();
		}
		return $this->Html->tag('ul', $code, array('class' => $class));
	}
	
		
	private function buildLink()
	{
		if ($this->isToken()) {
			return $this->Html->link(
				$this->value('label'),
				'#',
				$this->hasIcon()
			);
		}
		return $this->Html->link(
			$this->value('label'),
			$this->format('url', array('empty' => '#')),
			$this->hasIcon()
		);
	}
	
	private function hasIcon()
	{
		if (!$this->value('icon')) {
			return false;
		}
		return array('class' => 'fi-'.$this->value('icon'));
	}
	
	public function isToken()
	{
		if (strpos($this->value('url'), '//') !== false) {
			return true;
		}
		return false;
	}
}