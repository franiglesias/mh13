<?php
/**
 * Upable Model Behavior
 * 
 * Prepares a field to manage file uploading
 *
 * @package uploads.plugins.mh13
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Model', 'Uploads.Upload');

class UpableBehavior extends ModelBehavior {
	
	var $model;

/**
 * Contains configuration settings for use with individual model objects.
 * Individual model settings should be stored as an associative array, 
 * keyed off of the model name.
 *
 * @var array
 * @access public
 * @see Model::$alias
 */
	var $settings = array();
	var $defaults = array(
		'move' => 'route',		// (string) route, private or a path: where to move uploaded file from uploads
		'return' => 'link',		// (string) link, path, id (upload_id): what to return
		'transform' => false,	// (string): transformation to apply to file (images only)
		'attach' => false,		// (boolean): create an upload model record and attach actual model
		'conflict' => 'rename'	// (string) rename/overwrite: what to do in case of file name conflict
		);

/**
 * Stores info to attach files as attachments in the aftersave, when we know the
 * model id
 *
 * @var string
 */
	var $attachments = array();

/**
 * A path outside of the webroot to store all files
 *
 * @var string
 */
	var $private = '';

/**
 * Routes map based in main mimetype. Routes are relative to webroot (or private
 * path if is the case)
 *
 * @var string
 */
	var $routes = array(
		'image' => 'img',
		);
		
	var $defaultRoute = 'files';
/**
 * Allows the mapping of preg-compatible regular expressions to public or
 * private methods in this class, where the array key is a /-delimited regular
 * expression, and the value is a class method.  Similar to the functionality of
 * the findBy* / findAllBy* magic methods.
 *
 * @var array
 * @access public
 */
	var $mapMethods = array();


/**
 * Initiate Upable Behavior
 * 
 * _settings key = default options for all fields
 * 
 * Options (for each field)
 * 
 * move	(string)		where to move the uploaded file
 * 		private:		move to a store outside of the webroot
 * 		route: 			route based on type of file
 * 		path:			a path relative to webroot or absolute if starting with /
 * return (string)		content to populate the field
 * 		path:			absolute path to the file
 * 		link:			relative path to the file, according to type
 * 		upload:			upload model id created	
 * transform (mixed)	transformation to apply to the file (n/a)
 * attach (boolean)		creates an upload model and attaches model
 *
 * @param object $model
 * @param array $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		$settings = array();
		if (isset($config['_settings'])) {
			$settings = $config['_settings'];
			unset($config['_settings']);
		} 
		$settings = array_merge($this->defaults, $settings);
		foreach ($config as $field => $options) {
			if(empty($field)) {
				$field = $options;
				$options = array();
			}
			$options = array_merge($settings, $options);
			$this->settings[$model->alias][$field] = $options;
		}
		$this->private = Configure::read('Uploads.private');
		$this->model = $model;
	}

	/* -- All possible behavior callbacks have been stubbed out. Remove those you do not need. -- */


/**
 * Before save callback
 *
 * @param object $model Model using this behavior
 * @return boolean True if the operation should continue, false if it should abort
 * @access public
 */
	function beforeSave(&$model) { 
		foreach ($this->settings[$model->alias] as $field => $options) {
			if (!empty($model->data[$model->alias][$field])) {
				$model->data[$model->alias][$field] = $this->whatToReturn($model->data[$model->alias][$field], $options['return']);
			}
		}

		return true;
	}


/**
 * Retrieves upload settings for one or all fields
 *
 * @param string $field if empty, returns settings for all fields
 * @return void
 */
	public function uploadSettings(&$model, $field = null)
	{
		if ($field) {
			return $model->Behaviors->Upable->settings[$model->alias][$field];
		}
		return $model->Behaviors->Upable->settings[$model->alias];
	}


/**
 * Computes what value should be returned to the field data
 *
 * @param string $path 
 * @param string $options 
 * @return void
 */	
	protected function whatToReturn($path, $options)
	{
		$options = strtolower($options);

		if (!in_array($options, array('path', 'link', 'id'))) {
			// error
			return false;
		}

		if ($options == 'path') {
			return $path;
		}

		if ($options == 'link') {
			$link =  str_replace(WWW_ROOT, '', $path);
			// Suppress img dir if the file is in img, due to HtmlHelper->image
			$link = preg_replace('%^img/%', '', $link);
			return $link;
		}

		// Return data of attached upload
	}

	
} // End of UpableBehavior

?>