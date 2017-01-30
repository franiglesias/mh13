<?php


App::import('Lib', 'fi_value/abstracts/FiFormatter');

class DateFormatter extends FiFormatter
{
	protected $_format = DATE_SHORT;

	public function __construct($Value, $format = null)
	{
		parent::__construct($Value, null);
	}

	public function format()
	{
		if (!$this->_Value->get()) {
			return false;
		}
		return date($this->_format, strtotime($this->_Value->get()));
	}
}

?>
