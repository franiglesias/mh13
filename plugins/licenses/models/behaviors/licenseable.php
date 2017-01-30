<?php
/**
 * Licenseable Model Behavior
 * 
 * [Short Description]
 *
 * @package default
 * @version $Id$
 * @copyright Fran Iglesias
 **/
class LicenseableBehavior extends ModelBehavior {

/**
 * Contains configuration settings for use with individual model objects.
 * Individual model settings should be stored as an associative array, 
 * keyed off of the model name.
 *
 * @var array
 * @access public
 * @see Model::$alias
 */
	var $settings = array('license_id' => 'license_id');

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
 * Initiate Licenseable Behavior
 * 
 * Bind the comment model to the main model as HasMany, so you automagically get
 * the comments related
 *
 * @param object $model
 * @param array $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		$this->settings = Set::merge($this->settings, $config);
		if (!$model->hasField($this->settings['license_id'])) {
			throw new InvalidArgumentException("Model {$model->alias} has not the {$this->settings['license_id']} field.");
		}
		$bindSettings = array(
			'License' => array(
				'className' => 'Licenses.License',
				'foreignKey' => $this->settings['license_id'],
				'dependent' => true,
				'exclusive' => false
				)
			);
		$model->bindModel(array('belongsTo' => $bindSettings), false);
		
		App::import('Model', 'Licenses.License');
		ClassRegistry::init('License')->bindModel(array('hasMany' => array($model->alias)), false);
	}

} // End of LicenseaBehavior

?>