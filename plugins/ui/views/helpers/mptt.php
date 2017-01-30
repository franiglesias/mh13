<?php
/**
 * MpttHelper
 * 
 * Render an array of data retrieved with find('threaded') as a nested list
 *
 * @package default
 * @version $Id$
 **/

class MpttHelper extends AppHelper {

	var $helpers = array('Html', 'Form');
	
/**
 * Recursively renders the nested list
 *
 * @param $data array of data from find('threaded')
 * @param $class string the main model class
 * @param $template string a template for String::insert with the fields of the main model
 * @return string HTML code
 * @package default
 */
	public function render($data, $class, $template)
	{
		if (empty($data)) {
			return false;
		}
		// debug($data);
		$code = array();
		$code[] = '<ul>';
		foreach ($data as $root) {
			foreach ($root as $key => $value) {
				if ($key == 'children') {
					// Recursion
					$code[] = $this->render($value, $class, $template);
					continue;
				}
				$item = String::insert($template, $value);
				$code[] = $this->Html->tag('li', $item);
			}
		}
		$code[] = '</ul>';
		return implode(chr(10), $code);
	}

}