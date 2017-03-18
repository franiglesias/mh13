<?php
/**
 *  app_model
 *
 *  Created by  on 2010-05-16.
 **/


class AppModel extends Model
{
	var $recursive = -1;
	var $actsAs = array('Containable');
	var $locale = null;
	var $states = null;

	private $EventManager;
/**
 * Toggles a boolean field value
 *
 * @param string $field 
 * @param string $id 
 * @return void
 * @author Tecknoid
 * 
 * http://nuts-and-bolts-of-cakephp.com/2008/09/16/nice-trick-to-toggle-your-model-field-in-cakephp/
 */
	function toggleField($field, $id = null) {
		if(empty($id)) {
			$id = $this->id;
		}
		$field = $this->escapeField($field);
		return $this->updateAll(array($field => '1 -' . $field), array($this->escapeField() => $id));
	}
	
	public function translatedFields($field = false) {
		if (!$this->Behaviors->attached('Translate')) {
			return false;
		}
		$s = $this->Behaviors->Translate->settings[$this->alias];
		if (is_numeric(key($s))) {
			$translatedFields = $s;
		} else {
			$translatedFields = array_keys($s);
		}
		if (!empty($field)) {
			if(in_array($field, $translatedFields)) {
				return true;
			} else {
				return false;
			}
		}
		return $translatedFields;
	}


/**
 * Rotates the content of a field between states
 * States are stored as natural numbers 0, 1, 2..., it's up to you the meaning of every state
 * When rotateField is called the actual value is increased by one. If max states are reached then,
 * restarts at 0 
 * 
 * A Model->states property is a good place to store an array for labeling the states, for example:
 *
 * var $states = array(
 *      'field' => array(0 => 'Undefined', 1 => 'Inactive', 2 => 'Active')
 * );
 *
 * @param string $field The field name to rotate
 * @param string $states Number of possible states
 * @param string $id Model ID
 * @return integer The new state
 */	
	public function rotateField($field, $states, $id = null)
	{
		$this->setId($id);
		
		$maxValue = --$states;
		
		$value = $this->field($field);
		if ($value == $maxValue) {
			$value = 0;
		} elseif ($value<$maxValue) {
			$value++;
		}
		
		$this->saveField($field, $value);
		return $value;
	}

    public function setId($id = null)
    {
        $exceptionMessage = __('A valid ID is needed to perform this model method.', true);
        if (!$id && !$this->id) {
            throw new InvalidArgumentException($exceptionMessage);
        }
        if ($id) {
            $this->id = $id;
        }
        if (!$this->exists()) {
            throw new InvalidArgumentException($exceptionMessage);
        }
    }
			
/**
 * Custom validation method to compare two fields. Use:
 *
 * 'rule' => array('match', 'match_field' [, 'hashType', boolean]);
 *
 * @param string $value
 * @param string $matchField The field against match the value
 * @param string $hash string (false) or a valid hash type (sha1/sha256/md5)
 * @param string $salt bool (false) add App.Salt to the hash
 *
*@return void
 */
	function match($value, $matchField, $hash = false, $salt = false) {
		$field = key($value);
		if (in_array($hash, array('sha1', 'sha256', 'md5'))) {
			$matchValue = Security::hash($this->data[$this->alias][$matchField], $hash, $salt);
		} else {
			$matchValue = $this->data[$this->alias][$matchField];
		}
		return $value[$field] == $matchValue;
    }
	
/**
 * Handles the before/after filter logic for find('count') operations.  Only called by Model::find().
 *
 * @param string $state Either "before" or "after"
 * @param array $query
 * @param array $data
 * @return int The number of records found, or false
 * @access protected
 * @see Model::find()
 */

	function _findCount($state, $query, $results = array()) {
	    if ($state === 'before') {
	        if (isset($query['type']) && $query['type'] != 'count') {
	            $query = $this->{'_find' . ucfirst($query['type'])}($state, $query);
	        }
			unset($query['fields']); // Test
			return parent::_findCount($state, $query);
	    }
	    return parent::_findCount($state, $query, $results);
	}

/**
 * Get selected locale for model. Wrapper for I18n
 *
 * @param Model $model Model the locale needs to be set/get on.
 * @return mixed string or false
 * @access protected
 */
	function _getLocale() {
		if (!isset($this->locale) || is_null($this->locale)) {
			if (!class_exists('I18n')) {
				App::import('Core', 'i18n');
			}
			$I18n =& I18n::getInstance();
			$I18n->l10n->get(Configure::read('Config.language'));
			$this->locale = $I18n->l10n->locale;
		}
		return $this->locale;
    }
	
/**
 * Deletes cache file given a key. You could use regexp kay, such as:
 *
 *    items
 *    items|plugin
 *    menu*
 *    etc
 *
 * @param string $key
 */
	public function _deleteCache($key)
	{
		$path = CACHE.'views/';
		$folder = new Folder($path);
		$files = $folder->find('^.*('.$key.').*$');
		foreach ($files as $file) {
			if (file_exists($path.$file)) {
				$this->log('Deleting '.$file, 'cache');
				unlink($path.$file);
			}
		}
	}
	
	public function init()
    {

	}
	
	public function load($id = null)
	{
		try {
			$this->setId($id);
			$this->data = $this->read(null);
		} catch (Exception $e) {
			$this->data = null;
			$this->id = null;
		}
	}
	
	public function null()
	{
		return empty($this->id) || empty($this->data);
	}
}
?>
