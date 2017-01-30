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

class MenuItemHelper extends SinglePresentationModelHelper {

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html');
	var $model = false;

	public function render()
	{
		if ($this->isEmpty()) {
			return '';
		}
		if ($this->isDivider()) {
			return $this->divider();
		}
		return $this->Html->tag('li', $this->buildLink());
		
	}
	
	private function isDivider()
	{
		return in_array($this->value('label'), array('/', '|'));
	}
	
	private function divider()
	{
		return $this->Html->tag('li', '', array('class' => 'divider'));
	}
	
	private function buildLink()
	{
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
	
}