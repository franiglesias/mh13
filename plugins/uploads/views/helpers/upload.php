<?php
/**
 * UploadHelper
 * 
 * A helper to create file fields in forms with support for preview of recent uploads
 * an other capabilities
 *
 * @package uploads.milhojas
 * @version $Rev$
 * @license MIT License
 * 
 * $Id$
 * 
 * $HeadURL$
 * 
 **/

App::import('Lib', 'FiImage');

class UploadHelper extends AppHelper {
	var $helpers = array('Html', 'Form', 'Ui.Media', 'Ui.XHtml', 'Js' => array('jquery'));
	
	var $uploaders = array();

/**
 * Extensions allowed for the different kinds of uploads
 *
 * @var string
 */	
	var $extensions = array(
		'image' => array('jpeg', 'jpg', 'png', 'gif'),
		'multimedia' => array('aiff', 'aif', 'mp3', 'mp4', 'm4a', 'm4v', 'ogg', 'ogv'),
		'enclosure' => array(	'aiff', 'aif', 'mp3', 'mp4', 'm4a', 'm4v', 
								'ogg', 'ogv', 'jpeg', 'jpg', 'png', 'gif', 'pdf'),
		'file' => array() // Any extension is valid
	);

/**
 * Default options to build the upload field combo
 *
 * @var array
 */	
	var $defaults = array(
		'label' => false,
		'type' => 'file',
		'mode' => 'inline',	//
		'enclosure' => false, // Is a enclosure for items
		'multiple' => false, // Allow multiple file selection
		'extensions' => 'file', // Allow extensions in this array (false = allow all)
		'files' => false, // Equivalent to "value". A list of files
		'image' => false, // Equivalent to "value" for images
		'url' => false, // The url to refresh the value part of the control,
		'after' => false,
		'before' => false,
		'update' => null, // ID of the HTML to update with a file list
		'bare' => false, // Don't wrap with a div
		'limit' => 314572800
	);

/**
 * Needed to build the right url and params for the requestAction to populate the file list
 *
 * @var array
 */
	var $urlKeys = array(
		'plugin' => true, 
		'controller' => true, 
		'action' => true
	);

/**
 * Load needed assets and create the code to init the uploaders
 *
 * @return void
 */
	function afterRender() {
		// Pass extensions info to javascript to syncronize it
		if (!($view =& ClassRegistry::getObject('view'))) {
			return;
		}
		$view->viewVars['jsVars']['extensions'] = $this->extensions;
		
		// Load all needed scripts and stylesheets for this helper
		$this->Html->script('/uploads/js/fileuploader', array('inline' => false));
		if (!defined('MH_DO_NOT_LOAD_CUSTOM_CSS')) {
			$this->Html->css('/uploads/css/fileuploader', null, array('inline' => false));
		}
	}
	
/**
 * Creates a field with an attached uploader. Result of the uploader is used to update
 * the field content.
 *
 * @param string $field 
 * @param string $options 
 * @return string HTML
 */	

	public function uploader($field, $options = array()) {
		// Merge options with defaults
		
		$options = array_intersect_key($options, $this->defaults);
		$options = array_merge($this->defaults, $options);
		
		// Prepare data to pass to the uploaders script
		
		// Field ID
		$this->setEntity($field);
		$id = $this->Form->domID($field);

		// The URL of the upload action
		$uploadAction = Router::url(array(
			'plugin' => 'uploads',
			'controller' => 'uploads',
			'action' => 'upload'
		));
		
		$multiple = 0;
		if ($options['multiple']) {
			$multiple = 1;
			$mode = 'attachment';
		} else {
			$mode = $options['mode'];
		}
		
		// The URL of the action to refresh the widget
		
		if ($mode == 'inline') {
			$refreshAction = Router::url(array(
				'plugin' => 'uploads', 
				'controller' => 'uploads', 
				'action' => 'single'
			));
		} else {
			// $options['mode'] == 'attachment'
			$refreshAction = Router::url(array(
				'plugin' => 'uploads',
				'controller' => 'uploads',
				'action' => 'attachments',
				$this->model(),
				$this->Form->value('id')
			), true);
		}
		
		if (!empty($options['enclosure'])) {
			$params['enclosure'] = 1;
		}
		
		// Extra update on upload complete
		
		$completeUrl = false;
		if (!empty($options['url'])) {
			$completeUrl = Router::url($options['url']);
		}
		
		// Build the uploader element, class uploader
		$theUploader = $this->Html->tag('div', $this->XHtml->ajaxLoading(), array(
			'id' 				=> $id.'-uploader',		// The ID for the uploader
			'class' 			=> 'uploader',			// The class to be selected
			'mh-upload' 		=> $uploadAction,		// The action to proccess the upload
			'mh-multiple' 		=> $multiple,			// Allow mulitple files
			'mh-mode' 			=> $mode,				// Inline or attachment mode
			'mh-refresh'		=> $refreshAction,		// The action to retrieve the list of loaded files
			'mh-class'			=> $this->model(),		// Model class
			'mh-plugin'			=> $this->params['plugin'],	// Plugin
			'mh-field'			=> $mode == 'inline' ? $field : false, // The field that contains data (inline)
			'mh-fk'				=> $this->Form->value('id'), // Foreign ke of model (attach)
			'mh-target'			=> $id,					// Field id Target to update
			'mh-extensions'		=> $options['extensions'],	// Allowed extensions for this field
			'mh-complete-url' 	=> $completeUrl,		// URL to get data for extra on complete update
			'mh-complete-update'=> $options['update'],	// The selector for extra on complete update
			'mh-limit'			=> $options['limit'],   // Max Size
		));
		
		// Build the full widget
		
		if (empty($options['bare'])) {
			$out[] = $this->Form->label($field, $options['label']);
		}
		$out[] = $this->Form->input($field, array('type' => 'hidden'));
		$out[] = $theUploader;
		
		if (empty($options['bare']) && !empty($options['after'])) {
			$out[] = $options['after'];
		}
		
		// Finish and return the code
		$code = implode(chr(10), $out);
		if (empty($options['bare'])) {
			$code = $this->Html->div('input small-12 columns', $code);
		}
		return $code;
	}

/**
 * Image upload. Wrapper for uploader.
 *
 * Default behavior: single inline image upload.
 *
 * Options:
 *
 * mode = inline/attach
 * multiple: false/true
 *
 * @param string $field 
 * @param string $options 
 * @return void
 */
	
	public function image($field, $options) {
		$defaults['extensions'] = 'image';
		$defaults['enclosure'] = false;
		$defaults['mode'] = 'inline';
		$defaults['multiple'] = false;
		$defaults['image'] = $this->Form->value($field);
		$options = Set::merge($defaults, $options);
		return $this->uploader($field, $options);
	}

	public function images ($field, $options) {
		$defaults['extensions'] = 'image';
		$defaults['enclosure'] = false;
		$defaults['multiple'] = true;
		$options = Set::merge($defaults, $options);
		return $this->uploader($field, $options);
	}


	public function multimedia($field, $options) {
		$defaults['extensions'] = 'multimedia';
		$defaults['enclosure'] = false;
		$options = Set::merge($defaults, $options);
		return $this->uploader($field, $options);
	}
	
	public function file($field, $options) {
		$defaults['extensions'] = 'file';
		$defaults['enclosure'] = false;
		$options = Set::merge($defaults, $options);
		return $this->uploader($field, $options);
	}
	
	public function enclosure($field, $options) {
		$defaults['extensions'] = 'enclosure';
		$defaults['enclosure'] = true;
		$options = Set::merge($defaults, $options);
		return $this->uploader($field, $options);
	}
	

/**
 * Converts a time in seconds into a hh:mm:ss expression
 *
 * @param string $time in seconds
 * @return string
 */	
	public function readablePlayTime($time) {
		if ($time == false) {
			return __d('uploads', 'n/a', true);
		}
		$seconds = $time % 60;
		$minutes = floor($time / 60);
		$hours = floor($minutes / 60);
		$minutes = $minutes % 60;
		return sprintf('%s:%02s:%02s', $hours, $minutes, $seconds);
	}
	
}



?>