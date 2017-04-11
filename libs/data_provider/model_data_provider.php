<?php

/**
* Binds a view Var that is a CakePHP Model array
*/

App::import('Lib', 'data_provider/abstracts/SingleDataProvider');
App::import('Lib', 'data_provider/interfaces/AttachedDataProvider');

class ModelDataProvider extends SingleDataProvider implements AttachedDataProvider{
	/**
	 * Contains the model key we want to use
	 *
	 * @var string
	 */
	protected $_model = false;
	
	public function hasField($field)
	{
		if (!$this->bound() || empty($this->_model) || !$this->hasModel()) {
			return false;
		}
		return array_key_exists($field, $this->_source[$this->_model]);
	}

    /**
     * Checks if the source has the model key in it
     *
     * @return boolean
     * @author Fran Iglesias
     */
    public function hasModel()
    {
        if (!$this->bound()) {
            return false;
        }

        return isset($this->_source[$this->_model]);
    }

	public function hasKey($key)
	{
		if (!$this->bound()) {
			return false;
		}
		return array_key_exists($key, $this->_source);
	}

    public function value($field)
	{
		return $this->_source[$this->_model][$field];
	}

    public function useModel($model)
	{
		$this->_model = $model;
		return $this;
	}

    public function getModel()
	{
		return $this->_model;
	}
	
}

?>
