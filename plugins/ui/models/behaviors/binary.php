<?php
/**
 * Binary Model Behavior
 * 
 * Helps to manage Binary Packed fields. A Binary packed field is shown as a multiple checkbox field.
 * Every checkbox has a 2^n value, so every option corresponds to a bit in the binary packed integer
 *
 * @package ui.milhojas
 * @version $Id$
 * @copyright Fran Iglesias
 **/
class BinaryBehavior extends ModelBehavior {

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
 * Initiate Binary Behavior
 *
 * @param object $model
 * @param array $config a list of field names to be treated as binary packed
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		if (empty($config)) {
			throw new InvalidArgumentException('No fields for Binary Behavior');
		}
		if (is_array($config) && !empty($config['fields'])) {
			$config = $config['fields'];
		}
		$this->settings[$model->alias]['fields'] = (array)$config;
	}

/**
 * Before validate callback. 
 * 
 * Packs the value.
 *
 * @param object $model Model using this behavior
 * @return boolean True if validate operation should continue, false to abort
 * @access public
 */
	function beforeValidate(&$model) { 
		foreach ($this->settings[$model->alias]['fields'] as $field) {
			if (isset($model->data[$model->alias][$field]) && is_array($model->data[$model->alias][$field])) {
				$value = array_sum($model->data[$model->alias][$field]);
				$model->data[$model->alias][$field] = $value;
			}
		}
		return true;
	}

}