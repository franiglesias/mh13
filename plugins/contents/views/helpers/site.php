<?php
/**
 * SiteHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Helper', 'SinglePresentationModelHelper');

class SiteHelper extends SinglePresentationModelHelper implements AutoLinkable {

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Ui.XHtml', 'Ui.FHtml');
	var $model = 'Site';
	var $var = 'site';
	
	public function cacheKey()
	{
		return parent::cacheKey();
	}
	
	/**
	 * full URL to himself
	 *
	 * @return string
	 * @author Fran Iglesias
	 */
	public function selfUrl()
	{
		return array(
			'plugin' => 'contents',
			'controller' => 'sites',
			'action' => 'view',
			$this->value('key')
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
				'site' => $this->value('key'),
				'ext' => 'rss'
			),
			$options
		); 
	}
	
	public function rss()
	{
		return $this->XHtml->rssLink(__d('contents', 'Site feed', true), 'site', $this->value('key'));
	}
}