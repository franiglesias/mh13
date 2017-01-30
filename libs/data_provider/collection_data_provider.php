<?php

App::import('Lib', 'data_provider/abstracts/MultipleDataProvider');
App::import('Lib', 'data_provider/interfaces/AttachedDataProvider');

class CollectionDataProvider extends MultipleDataProvider implements AttachedDataProvider
{
	protected $_model = null;
	
	public function attach(SingleDataProvider &$Single)
	{
		parent::attach($Single);
		if ($this->_model) {
			$this->_Single->useModel($this->_model);
		}
		return $this;
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
		
	public function hasModel()
	{
		if (!$this->bound()) {
			return false;
		}
		return isset($this->_source[0][$this->_model]);
	}

	
	
}

?>