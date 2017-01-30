<?php
/**
 *  duplicable
 *
 *  Created by  on 2008-02-08.
 *  Copyright (c) 2008 Macintec. All rights reserved.
 **/

/**
 * Add methods to duplicate models, optionally taking care of associations
 * 
 * Duplicable is compatible with Translate Behavior
 *
 * Usage:
 *
 * $this->Model->duplicate($id[, $options]);
 *
 * @package default
 **/

class DuplicableBehavior extends ModelBehavior
{
	var $_defaultOptions = array(
		'cascade' => false,				// Duplicate associations
		'changeFields' => array(),		// Change this fields
		'changeString' => '%s dup.',	// With this sprintf formatted string (use %s as container for original value)
		'whitelist' => array(),			// Fields that should be duplicated. Leave empty for all
		'associations' => array(),		// What associations to duplicate
		'callbacks' => false			// Execute callbacks. False by default
		);
		
function setup(&$model, $options) {
	$this->_defaultOptions[$model->alias] = array_merge($this->_defaultOptions, $options);
}

/**
 * Duplicates a record
 *
 * @param $id mixed The id of the record to duplicate
 * @param $options array A keyed array of options to customize the duplication, see $_defaultOptions for more help
 * @return mixed, the $id of the new record
 **/

function duplicate (&$model, $id, $options = array()) {
	/**
	 * Merge options passed with defaults
	 *
	 */
	$options = array_merge($this->_defaultOptions[$model->alias], $options);
	
	/**
	 * Select the fields to duplicate as needed, fields out of whitelist get default
	 * values thanks to the model::create($data) method. If no whitelist, duplicate all
	 * fields
	 *
	 */
	$fields = null;
	
	if (!empty($options['whitelist'])) {
		if (is_string($options['whitelist'])) {
			$options['whitelist'] = array($options['whitelist']);
		}
		$fields = $options['whitelist'];
	}
	
	if ($options['cascade']) {
		if ($options['associations']) {
			$model->contain($options['associations']);
		} else {
			$model->recursive = 2; // Set recursive to allow retrieve assoc data
			
		}
	}
	if (!empty($model->isMultilingual)) {
		$original = $model->get($fields, $id);
	} else {
		$original = $model->read($fields, $id);
	}
	$original[$model->alias][$model->primaryKey] = false;
	// Store original id if needed for something
	$model->oldId = $id;
	$model->id = false;

	/**
	 * You may set some fields to change their values to show that they belongs to duplicate
	 * records.
	 * 
	 */
	if (!empty($options['changeFields'])) {
		foreach ((array)$options['changeFields'] as $field) {
			if (empty($original[$model->alias][$field])) {
				$this->log(sprintf('---> Trying to duplicate %s model', $model->alias), 'debug');
			}
			if (is_array($original[$model->alias][$field])) {
				$values = array();
				foreach ($original[$model->alias][$field] as $key => $value) {
					$values[$key] = sprintf($options['changeString'], $value);
				}
				$original[$model->alias][$field] = $values;
				continue;
			}
			$original[$model->alias][$field] = sprintf($options['changeString'], $original[$model->alias][$field]);
		}
	}
	$model->create();
	$model->set($original);
	/**
	 * Try to save the model. If not, return false
	 *
	 */
	$data = $model->data;
	if (!$model->save()) {
		return false;
	}
	$model->data = $data;
	/**
	 * Callback for model::afterDuplicate, you may write a method to change the model
	 * values programmatically when duplicating. Modify model->data array as needed.
	 *
	 */
	if ($options['callbacks'] && method_exists($model, 'afterDuplicate')) {
		$model->afterDuplicate();
		$model->save();
	}
/**
 * We are going to process associations if cascade option is set. If not, we return
 * the id of the duplicated record as we are done. Update $model->id
 *
 */

	$new = $model->id = $model->getInsertID();
	if (!$options['cascade']) {
		return $new;
	}
	
/**
 * Here, we collect the associations we want to duplicate, if not specified in associations
 * option, then duplicate all. Every type of association needs a different process.
 * By the way, belongsTo are automatic (foreignKeys are actual fields of the model)
 *
 */
	$associations = array_keys(array_merge($model->hasMany, $model->hasAndBelongsToMany, $model->hasOne));
	if (!empty($options['associations'])) {
		$associations = array_intersect($associations, $options['associations']);
	}

	foreach ($associations as $association) {
		if (isset($model->hasMany[$association]) || isset($model->hasOne[$association])) {
			if (isset($model->hasMany[$association])) {
				$class = $model->hasMany[$association]['className'];
				$key = $model->hasMany[$association]['foreignKey'];
			} else {
				$class = $model->hasOne[$association]['className'];
				$key = $model->hasOne[$association]['foreignKey'];
			}
			$dataSet = Set::extract('/'.$class, $original);
			foreach($dataSet as $record) {
				$data = $record;
				$data[$class][$key] = $new;
				unset($data[$class][$model->{$class}->primaryKey]);
				$model->{$class}->id = null; // Force new record
				$model->{$class}->create($data);
				$model->{$class}->save();
			}
		} elseif (isset($model->hasAndBelongsToMany[$association])) {
			$class = $model->hasAndBelongsToMany[$association]['className'];
			$table = $model->hasAndBelongsToMany[$association]['joinTable'];
			$key = $model->hasAndBelongsToMany[$association]['foreignKey'];
			$assocKey = $model->hasAndBelongsToMany[$association]['associationForeignKey'];
			$dataSet = Set::extract('/'.$class.'/id', $original);
			foreach($dataSet as $keyValue) {
				$sql = "INSERT INTO {$table} ({$key}, {$assocKey}) VALUES ('{$new}', '{$keyValue}')";
				$model->query($sql);
			}
		}
	}

	return $new;
	}

} // END class DuplicableBehavior extends ModelBehavior

?>
