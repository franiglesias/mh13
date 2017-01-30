<?php
App::import('Lib', 'fi_value/formatters/DateFormatter');

class LongDateFormatter extends DateFormatter {
	protected $_format = DATE_LONG;
}

?>
