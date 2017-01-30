<?php

App::import('Lib', 'fi_value/Value');
App::import('Lib', 'fi_value/formatters/FormatterFactory');

class FormatterEngine
{
	private $Value;
	private $FormatterFactory;
	
	public function __construct(FiValue $Value, FormatterFactory $FormatterFactory)
	{
		$this->Value = $Value;
		$this->FormatterFactory = $FormatterFactory;
	}
	
	public function apply($value, $type, $format = false)
	{
		$this->Value->set($value);
		if ($type == 'multi') {
			$type = $format;
			$format = array();
		}
		if (is_array($type)) {
			$Formatter = $this->FormatterFactory->build($this->Value, $type);
		} else {
			$Formatter = $this->FormatterFactory->get($this->Value, $type, $format);
		}
		return $Formatter->get();
	}

}

?>