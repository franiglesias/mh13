<?php
/**
 * MultilingualHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class MultilingualHelper extends AppHelper {

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Form', 'Session');
	var $languages = array();
	
	public function addLanguage($key, $name, $translate)
	{
		$this->languages[$key] = array(
			'name' => $name,
			'translate' => $translate
		);
	}
	
	public function element($element, $options = array())
	{
		$languages = Configure::read('Config.languages');
		$currentSessionLanguage = $this->Session->read('Config.language');
		$code = '';
		foreach ($languages as $key) {
			$_SESSION['Config']['language'] = $key;
			$langOptions = array(
				'language' => $key,
				'translate' => $this->languages[$key]['translate'],
				'languageName' => $this->languages[$key]['name']
			);
			$langOptions = array_merge($langOptions, $options);
			$View = ClassRegistry::getObject('View');
			$code .= $View->element($element, $langOptions);
		}
		$_SESSION['Config']['language'] = $currentSessionLanguage;
		return $code;
	}
}