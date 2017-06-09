<?php

/**
 * XHtmlHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class XHtmlHelper extends AppHelper {

	var $helpers = array('Html', 'Time');
	
	public function time($time, $format = 'j-m-Y')
	{
		$visible = $this->Time->format($format, $time);
		$timeStamp = $this->Time->format('j-m-y H:i', $time);
		return $this->Html->tag('time', $visible, array('datetime' => $timeStamp));
	}


/**
 * Creates the code for a RSS link
 *
 * @param string $label
 * @param string $channelSlug
 *
 * @return void
 * @author Fran Iglesias
 */
	public function rssLink($label, $type = false, $key = false)
	{
		$type = strtolower($type);
		switch ($type) {
			case 'channel':
				$url = array(
					'plugin' => 'contents',
					'controller' => 'items',
					'action' => 'feed',
					'channel' => $key,
					'ext' => 'rss'
					);
					break;
			case 'site':
				$url = array(
					'plugin' => 'contents',
					'controller' => 'items',
					'action' => 'feed',
					'site' => $key,
					'ext' => 'rss'
					);
				break;
			default:
				$url = array(
					'plugin' => 'contents',
					'controller' => 'items',
					'action' => 'feed',
					'ext' => 'rss'
					);
				break;
		}
		
		if (!defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
			$inline = false;
		} else {
			$inline = true;
		}
		
		$code = $this->Html->meta($label, $url, array('type' => 'rss', 'inline' => $inline));
		return $code;
	}
	
	public function ajaxLoading($id = 'busy-indicator', $show = false)
	{
		if (!is_string($id)) {
			$id = 'busy-indicator';
			$show = true;
		}
		if ($show) {
			$style = 'display: inline;';
		} else {
			$style = 'display: none;';
		}
		$code = $this->Html->image('/ui/img/assets/ajax-loader.gif');
		return $this->Html->div(null, $code, array('id' => $id, 'style' => $style, 'class' => 'mh-busy-indicator'));
	}
	
}
?>
