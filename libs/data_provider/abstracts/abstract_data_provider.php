<?php

/**
 * Implements DataProvider Interface and provides subclasses with some basic implementation
 *
 * @package default
 * @author Fran Iglesias
 */
App::import('Lib', 'data_provider/interfaces/DataProvider');
// App::import('Lib', 'data_provider/DataProviderFactory');

abstract class AbstractDataProvider implements DataProvider {
	
	// Contains a reference to the var that is the source of data
	protected $_source = null;
	
	public function __construct(&$var = null)
	{
		$this->_source = &$var;
	}
	
	// Interface implementation
	
	public function bind(&$var)
	{
		if (!is_array($var)) {
			throw new InvalidArgumentException('Passed var is not an array', 1);
		}
        $this->_source = $var;
		return $this;
	}
	
	public function unbind()
	{
		$this->_source = null;
		return $this;
	}

	public function bound()
	{
		return !is_null($this->_source);
	}
	
	public function &source($key = false)
	{
		
		if (!$key) {
			return $this->_source;
		}
		if (isset($this->_source[$key])) {
			return $this->_source[$key];
		}
		throw new InvalidArgumentException(sprintf('Key %s doesn\'t exist in DataSource.', $key));
	}

	public function dataSet()
	{
		return $this->_source;
	}

	
	public function isEmpty()
	{
		return empty($this->_source);
	}
	
	public function getKeyDataProvider($key)
	{
		if (!isset($this->_source[$key])) {
			throw new InvalidArgumentException(sprintf('Key %s doesn\'t exist in DataSource.', $key));
		}
		return ClassRegistry::init('DataProviderFactory')->make($this->_source[$key]);
	}
	
	public function getKeyDataSet($key)
	{
		if (!isset($this->_source[$key])) {
			throw new InvalidArgumentException(sprintf('Key %s doesn\'t exist in DataSource.', $key));
		}
		return $this->_source[$key];
	}
	
}

?>
