<?php

/**
 * A model to manage simple colections of images
 *
 * @package default
 */

class ImageCollection extends UploadsAppModel {
	var $name = 'ImageCollection';
	var $displayField = 'title';
	var $actsAs = array(
		'Uploads.Attachable' => array('Image'),
		'Ui.Sluggable' => array('update' => true)
	);
	
	public function init()
	{
		$this->set(array(
			'type' => 'wall'
 		));
	}
}
?>