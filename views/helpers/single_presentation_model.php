<?php

App::import('Helper', 'presentation_model/PresentationModel');
App::import('Lib', 'fi_value/formatters/FormatterEngine');

class SinglePresentationModelHelper extends PresentationModelHelper
{
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->FormatterEngine = new FormatterEngine(new Value, new FormatterFactory);
	}
	
	public function value($field)
	{
		if (!$this->DataProvider->hasField($field)) {
			return null;
		}
		return $this->DataProvider->value($field);
	}

	public function setFormatter(FormatterEngine $Formatter)
	{
		$this->FormatterEngine = $Formatter;
	}
	
	public function format($field, $format, $params = false)
	{
		if (!$this->DataProvider->hasField($field)) {
			$value = $field;
		} else {
			$value = $this->value($field);
		}
		return $this->FormatterEngine->apply($value, $format, $params);
	}
	
	# 
	
	public function link(PresentationModelHelper &$Helper, $key)
	{
		if (!$this->DataProvider->hasKey($key)) {
			return false;
		}
		$Helper->setDataProviderFactory($this->DataProviderFactory);
		$Helper->bind($this->DataProvider->source($key));
	}

	public function hasKey($key)
	{
		return $this->DataProvider->hasKey($key);
	}
	/**
	 * full URL to himself
	 *
	 * @return string
	 * @author Fran Iglesias
	 */
	public function self($full = false)
	{
		return Router::url($this->selfUrl(), $full);
	}
	
	public function countKey($key)
	{
		return count($this->DataProvider->getKeyDataSet($key));
	}
	
}

?>
