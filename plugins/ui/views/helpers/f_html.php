<?php
/**
 * FHtmlHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

interface AutoLinkable {
	function selfUrl();
}

class FHtmlHelper extends AppHelper {
	

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Form', 'Ui.Media');
	var $View;
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->View =& ClassRegistry::getObject('View');
	}
	
	public function permalink(AutoLinkable $SPM, $label = null, $options = array())
	{
		if (is_null($label)) {
			$label = __('Permalink', true);
		} else {
			$label = $SPM->format($label, array('empty' => 'label'));
		}
		return $this->Html->link($label, $SPM->selfUrl(), $options);
	}
	
	public function image(SinglePresentationModelHelper $SPM, $field, $options = array())
	{
		if (!$SPM->value($field)) {
			return false;
		}
		if (is_string($options)) {
			$options = array('size' => $options);
		}
		$defaults = array(
			'size' => 'channelMenuIcon',
			'class' => false
		);
		$options = array_merge($defaults, $options);
		return $this->Media->image($SPM->value($field), array(
			'size' => $options['size'], 
			'attr' => $options
		));
	}
	
/**
 * Generates a title string taking care if there are tag or other filters applied
 *
 * @return string
 */	
	public function title(SinglePresentationModelHelper $SPM)
	{
		$template = __d('contents', 'Last articles in channel <strong>%s</strong>', true);
		if ($tag = $this->View->getVar('tag')) {
			$template .= sprintf(__d('contents', ' labeled with <strong>%s</strong>', true), $tag);
		}
		if ($level = $this->View->getVar('level_id')) {
			$levels = $this->View->getVar('levels');
			$template .= sprintf(__d('contents', ' labeled with <strong>%s</strong>', true), $levels[$level]);
		}
		return $SPM->format('title', 'string', $template);
	}
	
}