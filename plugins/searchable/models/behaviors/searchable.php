<?php
/**
 * Searchable Model Behavior
 * 
 * Adds models the ability to be searchable using a index table that is automatically updated when inserting, 
 * editing and deleting records.
 *
 * @package searchable.milhojas
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Core', 'Sanitize');
class SearchableBehavior extends ModelBehavior {

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
	var $mapMethods = array(
		'/^_findSearch$/' => '_findSearch',
		'/^_findIndex$/' => '_findIndex',
		);
		
	var $scores = false;
/**
 * Initiate Searchable Behavior. Normalizes the indexable field names
 *
 * @param object $model
 * @param array $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		$model->_findMethods['search'] = true;
		$model->_findMethods['index'] = true;
		if (is_string($config)) {
			$config = array('fields' => array($config));
		}
		$fullFields = array();
		foreach ($config['fields'] as $field) {
			if (strpos($field, '.') === false) {
				$f = $field;
				$m = $model->alias;
			} else {
				list($m,$f) = explode('.', $field);
			}
			if (empty($f)) {
				$f = $m;
				$m = $model->alias;
			}
			$fullFields[] = "$m.$f";
		}
		$config['fields'] = $fullFields;
		$this->settings[$model->alias] = $config;
	}

/**
 * Saves a Sindex record for a Model record
 *
 * @param string $model 
 * @return void
 */	
	public function setIndex(&$model) {
		App::import('Model', 'Searchable.Sindex');
		$Sindex = ClassRegistry::init('Sindex');
		$Sindex->deleteAll(array('model' => $model->alias, 'fk' => $model->id));
		$data = $this->computeIndex($model, $model->data);
		$Sindex->create($data);
		return $Sindex->save();
	}

/**
 * Compute the Sindex record given the model and a model data array
 *
 * @param string $model 
 * @param string $data 
 * @return void
 */
	public function computeIndex(&$model, $data) {
		$fields = $this->settings[$model->alias]['fields'];
		$content = false;
		foreach ($fields as $field) {
			list($m, $f) = explode('.', $field);
			$part = Set::extract("/$m/$f", $data);
			if (is_array($part)) {
				$part = implode(' ', $part);
			}
			$content .= ' '.$part;
		}
		// Needed to manage international characters
		$content = mb_convert_encoding($content, 'ISO-8859-1');
		$content = mb_convert_encoding($content, 'UTF-8', 'HTML-ENTITIES');
		$content = strip_tags($content);
		$content = Sanitize::clean($content, array('encode' => false, 'remove_html' => false, 'odd_spaces' => true));
		
		return array(
			'model' => $model->alias,
			'fk' => $data[$model->alias]['id'],
			'content' => trim($content)
		);

	}


	public function searchIndexStatus(&$model) {
		App::import('Model', 'Searchable.Sindex');
		$Sindex = ClassRegistry::init('Sindex');
		$indexes = $Sindex->find('count', array('conditions' => array('Sindex.model' => $model->alias)));
		$records = $model->find('count');
	}
	

/**
 * Custom find method. Searches for a term in the model using a unique query
 *
 * @param string $model 
 * @param string $method 
 * @param string $state 
 * @param string $query key 'term' for the search
 * @param string $results 
 * @return array with results or false
 */
	public function _findSearch(&$model, $method, $state, $query, $results = array()) {
		if ($state === 'before') {
			App::import('model', 'Searchable.Sindex');
			$settings = array(
				'className' => 'Sindex',
				'foreignKey' => 'fk',
				'conditions' => array('Sindex.model' => $model->alias) 
			); 
			$model->bindModel(array('hasOne' => array('Sindex' => $settings)));
			if (!empty($query['fields'])) {
				$fields = Set::merge($query['fields'], array(
					$model->alias.'.*',
					'Sindex.fk',
					'MATCH (Sindex.content) AGAINST (\'' . $query['term'] . '\') AS score'
				));
			} else {
				$fields = array(
					$model->alias.'.*',
					'Sindex.fk',
					'MATCH (Sindex.content) AGAINST (\'' . $query['term'] . '\') AS score'
				);
			}
			$conditions['MATCH(Sindex.content) AGAINST(? IN BOOLEAN MODE)'] = $query['term'];
			$joins = array(
				array(
					'table' => 'sindices',
					'alias' => 'Sindex',
					'type' => 'left',
					'conditions' => array(
						"Sindex.model = '{$model->alias}'",
						'Sindex.fk = '.$model->alias.'.id'
					)
				)
			);
			$order = array('score' => 'desc');

			unset($query['term']);

			$query = Set::merge($query, compact('fields', 'conditions', 'joins', 'order', 'contain'));
			return $query;
		}
		foreach ($results as &$record) {
			$record[$model->alias]['score'] = $record[0]['score'];
			unset($record[0]);
		}
		return $results;
	}

/**
 * Custom find method to retrieve all records from the Model to search. Uses some introspection to extract only relevant fields
 * and avoid an overflow of data using Containable. Use without options
 *
 * $Model->find('index');
 *
 * @param string $model injects the model into the method
 * @param string $method injects the method name
 * @param string $state before/after
 * @param array $query The query, use empty
 * @param string $results 
 * @return array The found records
 */	
	public function _findIndex(&$model, $method, $state, $query, $results = array()) {
		if ($state === 'before') {
			$fieldsList = $model->Behaviors->Searchable->settings[$model->alias]['fields'];
			$contain = $fields = array();
			foreach ($fieldsList as $field) {
				list($m, $f) = explode('.', $field);
				if ($m != $model->alias) {
					$contain[] = $field;
				} else {
					$fields[] = $field;
				}
			}
			$query = Set::merge($query, compact('fields', 'contain'));
			return $query;
		}
		return $results;
	}


/**
 * After save callback. Saves the index when the record is stored
 *
 * @param object $model Model using this behavior
 * @param boolean $created True if this save created a new record
 * @access public
 * @return boolean True if the operation succeeded, false otherwise
 */
	function afterSave(&$model, $created) { 
		$model->recursive = 2;
		$model->read();
		$this->setIndex($model);
		return true;
	}

/**
 * Before delete callback. Remove Sindex records for Model when it's deleted
 *
 * @param object $model Model using this behavior
 * @param boolean $cascade If true records that depend on this record will also be deleted
 * @return boolean True if the operation should continue, false if it should abort
 * @access public
 */
	function beforeDelete(&$model, $cascade = true) { 
		App::import('Model', 'Searchable.Sindex');
		$Sindex = ClassRegistry::init('Sindex');
		$result = $Sindex->deleteAll(array('Sindex.model' => $model->alias, 'Sindex.fk' => $model->id));
		unset($Sindex);
		return $result;
	}

}