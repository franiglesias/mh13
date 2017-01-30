<?php
/**
 * Multilingual Model Behavior
 * 
 * [Short Description]
 *
 * @package ui.mh13
 * @author Frankie
 * @version $Id$
 * @copyright Fran Iglesias
 **/
class MultilingualBehavior extends ModelBehavior {

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
	 * Initiate Multilingual Behavior
	 *
	 * @param object $model
	 * @param array $config
	 * @return void
	 * @access public
	 */
	function setup(&$model, $config = array()) {
		if (!$model->Behaviors->attached('Translate')) {
			throw new Exception('MUltilingual model must have Translate Behavior attached.');
		}
		$model->isMultilingual = true;
	}

/**
 * MUltilingual wrapper for read
 *
 * @param string $model The model
 * @param string $fields Array of fields to retrieve
 * @param string $id ID of the record
 * @param string $contains Array of model to contain
 * @return array
 */
	public function get(&$model, $fields = null, $id = null) {
		$st = $model->Behaviors->Translate->settings[$model->alias];
		$translations = array_values($st);
		if (!empty($model->Behaviors->Containable->runtime[$model->alias]['contain'])) {
			$model->Behaviors->Containable->runtime[$model->alias]['contain'] = array_merge($model->Behaviors->Containable->runtime[$model->alias]['contain'], $translations);
		} else {
			$model->contain($translations);
		}
		$result = $model->read($fields, $id);
		if (!$result) {
			return false;
		}
		foreach ($st as $field => $translation) {
			unset($result[$model->alias][$field]);
			foreach ($result[$translation] as $value) {
				$result[$model->alias][$value['field']][$value['locale']] = $value['content'];
			}
			unset($result[$translation]);
		}
		return $result;
	}
	
/**
 * Ensures that translated fields are populated, to avoid
 *
 * @param string $model 
 * @return void
 * @author Frankie
 */	
	public function init(&$model) {
		$st = $model->Behaviors->Translate->settings[$model->alias];
		$languages = Configure::read('Config.languages');
		foreach ($st as $field => $translations) {
			foreach ($languages as $language) {
				$data[$field][$language] = '';
			}
		}
		return $data;
	}
	
	

}