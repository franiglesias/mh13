<?php
/**
 * StaticPageHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Helper', 'SinglePresentationModel');

class StaticPageHelper extends SinglePresentationModelHelper implements AutoLinkable 
{
	var $var = 'staticPage';
	var $model = 'StaticPage';
	var $helpers = array('Html', 'Form', 'Ui.Media');

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
			'controller' => 'static_pages',
			'action' => 'view',
			$this->value('slug')
		);
	}
	
}