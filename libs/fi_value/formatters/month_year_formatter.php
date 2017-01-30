<?php
App::import('Lib', 'fi_value/formatters/DateFormatter');

class MonthYearFormatter extends DateFormatter {
	protected $_format = 'M-y';
}

?>
