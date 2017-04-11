<?php

/**
 * Implements DataProvider Interface
 *
 * @package default
 * @author Fran Iglesias
 */
App::import('Lib', 'data_provider/abstracts/AbstractDataProvider');
App::import('Lib', 'data_provider/interfaces/MultiDataProvider');
App::import('Lib', 'SimpleIterator');

abstract class MultipleDataProvider extends AbstractDataProvider implements MultiDataProvider{

	var $Iterator = null;
	protected $_Single = null;
	
	public function __construct($Iterator, &$var = null)
	{
		parent::__construct($var);
		$this->Iterator = $Iterator;
		if (!is_null($var)) {
			$this->Iterator->bind($this->_source);
		}
	}
	
	public function bind(&$var)
	{
		parent::bind($var);
		$this->Iterator->bind($this->_source);
		return $this;
	}
	
	public function attach(SingleDataProvider &$Single)
	{
		if (!$this->bound()) {
			throw new Exception('You only can attach to a bound DataProvider', 1);
		}
        $this->_Single = $Single;
		$this->rewind();
		return $this;
	}

    public function rewind()
    {
        $this->Iterator->rewind();
    }

    public function next()
    {
        $this->Iterator->next();
        $this->sync();
    }
	
	protected function sync()
	{
		if (!$this->_Single) {
			return;
		}
		$this->_Single->bind($this->current());
	}
	
	public function &current()
	{
		return $this->Iterator->current();
	}
	
	public function hasNext()
	{
		return $this->Iterator->hasNext();
	}
	
	public function pointer($newPointer = null)
	{
		return $this->Iterator->pointer($newPointer);
	}
	
	public function count()
	{
		return $this->Iterator->count();
	}
}

?>
