<?php
/**
 * PageHelper
 * 
 * Sort of Presentation Model pattern for a Page
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Colegio Miralba
 **/
App::import('Helper', 'SinglePresentationModel');

class ImageHelper extends SinglePresentationModelHelper {
	
	var $helpers = array('Html', 'Form', 'Paginator', 'Ui.Media');
	var $var = 'image';
	
	public function render($options = array())
	{
		if (is_string($options)) {
			$options = array('size' => $options);
		}
		$image = $this->Media->image(
			$this->value('path'),
			$options
			);
			
		if ($this->value('url')) {
			$image = sprintf('<a href="%s">%s</a>', Router::url($this->value('url')), $image);
		}
		return $image; 
	}
	
	public function caption()
	{
		return sprintf('<strong>%s</strong>: %s', $this->value('name'), $this->value('description'));
	}

}