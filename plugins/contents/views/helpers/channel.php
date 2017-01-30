<?php
/**
 * ChannelHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Helper', 'SinglePresentationModel');

class ChannelHelper extends SinglePresentationModelHelper implements Autolinkable{

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Form', 'Ui.XHtml', 'Ui.Media', 'Menus.Menu', 'Ui.Block', 'Ui.Page');
	var $model = 'Channel';
	var $var = 'channel';

/**
 * Generates a cachekey
 *
 * @return string
 */
	public function cacheKey()
	{
		return parent::cacheKey(array('slug', 'level_id', 'tags'));
	}
	
	public function selfUrl()
	{
		return array(
			'plugin' => 'contents',
			'controller' => 'channels',
			'action' => 'view',
			$this->value('slug')
			);
	}
	
	public function rssLink($label = null, $class = false)
	{
		if (!$label) {
			$label = sprintf(__d('contents', '%s RSS Feed', true), $this->value('title'));
		}
		$options = false;
		if ($class) {
			$options['class'] = $class;
		}
		return $this->Html->link(
			$label,
			array(
				'plugin' => 'contents',
				'controller' => 'items',
				'action' => 'feed',
				'channel' => $this->value('slug'),
				'ext' => 'rss'
			),
			$options
		); 
		
	}
	
	
	public function rss()
	{
		return $this->XHtml->rssLink(__d('contents', 'Channel feed', true), 'channel', $this->value('slug'));
	}
	
	public function menu()
	{
		$menu = $this->value('menu_id');
		if (!$menu) {
			return false;
		}
		$label = $this->value('title');
		if ($this->value('icon')) {
			$icon = $this->Media->image($this->value('icon'), array(
				'size' => 'menuIcon',
				'attr' => array('class' => 'mh-channel-menu-home-icon')
				)
			);
			$label = $icon.$label;
		}
		$title = $this->Html->link($label, $this->selfUrl(), array('escape' => false));

		return $this->Menu->topbar($menu, $title);
	}
	
	public function homeTitle($options = false)
	{
		$template = 'brilliant';
		
		if (!$this->value('image')) {
			$template = 'simple'; 
		}
		
		return $this->Page->block('/ui/headers/'.$template, array(
			'title' => $this->value('title'),
			'tagline' => $this->value('tagline'),
			'image' => $this->value('image'),
			'icon' => $this->value('icon')
		));
	}
	
	public function noContent()
	{
		return $this->Html->tag('p', __d('contents', 'This channel has no content yet.', true));
	}
		
}