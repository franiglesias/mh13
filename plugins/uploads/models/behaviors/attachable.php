<?php
/**
 * Attachable Model Behavior
 * 
 * Allows model to be associated with uploaded files, creating several "virtual" relationships helps
 * to organize related files when retrieving data
 *
 * @package uploads.milhojas
 * @version $Id$
 * @copyright Fran Iglesias
 **/
class AttachableBehavior extends ModelBehavior {

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
 * Initiate Attachable Behavior
 *
 * @param object $model
 * @param array $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		if (!is_array($config)) {
			$config = array($config);
		}
		$this->bindUpload($model);
		$this->bindAttachment($model);
		if (in_array('Enclosure', $config)) {
			$this->bindEnclosure($model);
		}
		if (in_array('Image', $config)) {
			$this->bindImage($model);
		}
		if (in_array('MainImage', $config)) {
			$this->bindMainImage($model);
		}
		
		if (in_array('Multimedia', $config)) {
			$this->bindMultimedia($model);
		}
		
		if (in_array('Download', $config)) {
			$this->bindDownload($model);
		}
		if (in_array('File', $config)) {
			$this->bindFile($model);
		}
	}

	public function bindEnclosure(&$model) {
		$settings = array(
			'Enclosure' => array(
				'className' => 'Uploads.Upload',
				'conditions' => array(
					'Enclosure.model' => $model->alias,
					'Enclosure.enclosure' => 1
				),
				'foreignKey' => 'foreign_key',
				'order' => array('Enclosure.order' => 'asc')
			)
			
		);
		$model->bindModel(array('hasOne' => $settings), false);
	}
	
	public function bindImage(&$model) {
		$settings = array(
			'Image' => array(
				'className' => 'Uploads.Upload',
				'conditions' => array(
					'Image.model' => $model->alias,
					'Image.type LIKE' => 'image%'
				),
				'foreignKey' => 'foreign_key',
				'order' => array('Image.order' => 'asc')
			)
			
		);
		$model->bindModel(array('hasMany' => $settings), false);
	}

	public function bindMainImage(&$model) {
		$settings = array(
			'MainImage' => array(
				'className' => 'Uploads.Upload',
				'conditions' => array(
					'MainImage.model' => $model->alias,
					'MainImage.type LIKE' => 'image%',
				),
				'fields' => array('id', 'path'),
				'foreignKey' => 'foreign_key',
				'order' => array('MainImage.order' => 'ASC'),
				'limit' => 1
			)
			
		);
		$model->bindModel(array('hasMany' => $settings), false);
	}



	public function bindMultimedia(&$model) {
		$settings = array(
			'Multimedia' => array(
				'className' => 'Uploads.Upload',
				'conditions' => array(
					'Multimedia.model' => $model->alias,
					'or' => array(
						array('Multimedia.type LIKE' => 'video%'),
						array('Multimedia.type LIKE' => 'audio%'),
					),
					'Multimedia.enclosure' => false
				),
				'foreignKey' => 'foreign_key',
				'order' => array('Multimedia.order' => 'asc')
			)
			
		);
		$model->bindModel(array('hasMany' => $settings), false);
	}

	
	public function bindDownload(&$model) {
		$settings = array(
			'Download' => array(
				'className' => 'Uploads.Upload',
				'conditions' => array(
					'Download.model' => $model->alias,
					array('Download.type NOT LIKE' => 'image%'),
					array('Download.type NOT LIKE' => 'video%'),
					array('Download.type NOT LIKE' => 'audio%'),
					'Download.enclosure' => false
				),
				'foreignKey' => 'foreign_key',
				'order' => array('Download.order' => 'asc')
			)
			
		);
		$model->bindModel(array('hasMany' => $settings), false);
	}
	
	public function bindUpload(&$model) {
		$settings = array(
			'Upload' => array(
				'className' => 'Uploads.Upload',
				'conditions' => array(
					'Upload.model' => $model->alias,
				),
				'foreignKey' => 'foreign_key',
				'order' => array('Upload.order' => 'asc')
			)
			
		);
		$model->bindModel(array('hasMany' => $settings), false);
	}
	
	public function bindAttachment(&$model)
	{
		$settings = array(
			'Attachment' => array(
				'className' => 'Uploads.Upload',
				'conditions' => array(
					'Attachment.model' => $model->alias,
					'Attachment.enclosure' => false
				),
				'foreignKey' => 'foreign_key',
				'order' => array('Attachment.order' => 'asc')
			)
			
		);
		$model->bindModel(array('hasMany' => $settings), false);
	}
	
	public function bindFile(&$model)
	{
		$settings = array(
			'File' => array(
				'className' => 'Uploads.Upload',
				'conditions' => array(
					'File.model' => $model->alias,
				),
				'foreignKey' => 'foreign_key',
			)
			
		);
		$model->bindModel(array('hasOne' => $settings), false);
	}

	
} // End of AttachableBehavior

?>