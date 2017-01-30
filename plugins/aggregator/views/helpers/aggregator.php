<?php

/**
* Utility methods and functions to format aggregator entries
*/

App::import('Core', 'Sanitize');

class AggregatorHelper extends AppHelper
{
	var $helpers = array('Html', 'Ui.Article');

/**
 * Builds a status string for a status entry
 *
 * @param string $status 
 * @return string
 */
	public function status($status) {
		if ($status) {
			return sprintf(__d('aggregator', 'This entry is %s, since the last update.', true), $status);
			}
		return __d('aggregator', 'This entry hasn\'t changed, since the last update.', true);
	}
	
/**
 * Returns language full name from language code
 *
 * @param string $language 
 * @return string
 */
public function language($language) {
	if (!$language) {
		return false;
	}
	$codes = ClassRegistry::init('L10n')->catalog($language);
	return __($codes['language'], true);
}

/**
 * Returns a copyright string for the entry
 *
 * @param string $copyright 
 * @return string
 */
public function copyright($copyright) {
	if (!$copyright) {
		return false;
	}
	if ($copyright[0] != '©') {
		return '© '.$copyright;
	}
	return $copyright;
}

/**
 * Returns a formated email 
 *
 * @param string $entry 
 * @return strj g
 */
public function contact($entry) {
	if (empty($entry['Entry']['email']) ){
		return $entry['Entry']['author'];
	}
	return $this->Html->link($entry['Entry']['author'], 'mailto:'.$entry['Entry']['email']);
}


/**
 * Attempts to clean the entry content
 *
 * @param string $text 
 * @return string Cleaned string
 */
public function clean($text)
{
	$text = Sanitize::stripWhitespace($text);
	//$text = str_replace('<p>', chr(10).'<p>', $text);
	$text = preg_replace_callback('/<(p|div)[^>]*>(.*?)<\/\1>/',create_function('$matches', 'return "<p>".trim($matches[2])."</p>".chr(10);'), $text);
	$text = Sanitize::stripTags($text, 'b', 'span', 'div', 'i', 'em', 'strong', 'iframe', 'object', 'br');
	$text = preg_replace('/style\s?=\s?"[^"]*"/', '', $text);
	$text = trim(preg_replace('/<([^> ]*)><\/\1>/', '', $text));
	return $text;
}
	
/**
 * Formats the content of an entry
 *
 * @param string $entry The record array
 * @param string $source full | none | feed the links to sources
 * @return string
 */
public function entry($entry, $source = 'full')
{
	$template = array(
		'none' => '',
		'feed' => __d('aggregator', '<span class="mh-breadcrumb mh-breadcrumb-feed">Feed: %s </span>', true),
		'full' => __d('aggregator', '<span class="mh-breadcrumb mh-breadcrumb-planet">Planet: %s</span> <span class="mh-breadcrumb mh-breadcrumb-feed">Feed: %s </span>', true)
	);
	
	// Compute parts for template
	$feed = $planet = '';
	
	$title = $this->Html->link($this->Article->title($entry['Entry']['title']),$entry['Entry']['url']);
	$excerpt = $this->Article->excerpt($entry['Entry']['content'], array('size' => 250));
	$status = $this->status($entry['Entry']['status']);
	if ($source != 'none') $feed = $this->_feedUrl($entry);
	if ($source == 'full') {
		$planet = $this->_planetUrl($entry);
		$source = sprintf($template[$source], $planet, $feed);
	} else {
		$source = sprintf($template[$source], $feed);
	}
	$local = $this->_localUrl($entry);
	$original = $this->_originalUrl($entry);
		
	$code = <<<HTML
<article class="media entry">
	<header class="media-header entry-header">
		<h1 class="heading entry-heading">{$title}</h1>
		<p class="mh-breadcrumb-list">{$source}</p>
	</header>
	<div class="media-body entry-body">{$excerpt}</div>
	<footer class="media-footer entry-footer">
		<p class="meta status mh-button-bar">{$original} {$local} {$status}</p>
	</footer>
</article>
HTML;
	return $code;
}

	protected function _feedUrl($entry) {
		return $this->Html->link(
			$entry['Feed']['title'],
			array(
				'plugin' => 'aggregator',
				'controller' => 'entries',
				'action' => 'feed',
				$entry['Feed']['slug']
				)
			);
	}

	protected function _planetUrl(&$entry) {
		return $this->Html->link(
			$entry['Feed']['Planet']['title'],
			array(
				'plugin' => 'aggregator',
				'controller' => 'entries',
				'action' => 'planet',
				$entry['Feed']['Planet']['slug']
				)
			); 
	}
	
	protected function _localUrl(&$entry) {
		return $this->Html->link(
			__d('aggregator', 'Our copy', true),
			array(
				'plugin' => 'aggregator',
				'controller' => 'entries',
				'action' => 'view',
				$entry['Entry']['id']
				),
			array('class' => 'mh-button mh-button-readmore')
			);
	}
	
	protected function _originalUrl(&$entry) {
		return $this->Html->link(
			__d('aggregator', 'Original', true),
			$entry['Entry']['url'],
			array('class' => 'mh-button mh-button-external')
			);
	}

	
}

?>