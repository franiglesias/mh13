<?php
/**
 * ItemHelper
 * 
 * [Short Description]
 *
 * @package contents.milhojas
 * @version $Id$
 **/

class PostHelper extends AppHelper {

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Form', 'Text');

	public function neighbors($neighbors, $options = array())
	{
		$prev = $this->link($neighbors['prev'], 'button mh-button-prev', $options);
		$next = $this->link($neighbors['next'], 'button mh-button-next', $options);
		return $this->Html->div('mh-neighbors', $prev . $next);
		
	}
	
	private function link($item, $class, $options = array())
	{
		if (empty($item)) {
			return false;
		}
		$item = $this->Html->link(
				$this->Text->truncate($item['Item']['title'], 40, array('ending' => '…', 'exact' => false)),
				array(
					'plugin' => 'contents',
					'controller' => 'items',
					'action' => 'view',
					$item['Item']['slug']
				),
				array('class' => $class)
			);
		if (!empty($options['tag'])) {
			return $this->Html->tag($options['tag'], $item);
		}
		return $item;
	}

}