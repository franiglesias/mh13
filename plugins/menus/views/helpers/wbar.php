<?php
/**
 * WbarHelper
 * 
 * Helper to create a footer navigation menu from a menu bar, Foundation based
 *
 * @package menus.mh13
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class WbarHelper extends BarHelper {

	public function render($bar, $options = array()) {
		if (empty($bar)) {
			return false;
		}
		$options = Set::merge($this->defaults, $options);
		$this->classses = $options['classes'];
		return $this->Html->tag(
			'ul', 
			$this->buildMenuList($bar), 
			array('class' => 'small-block-grid-1 medium-block-grid-3 large-block-grid-'.count($bar))
		);
	}
}