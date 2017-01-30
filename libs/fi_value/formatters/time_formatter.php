<?php
App::import('Lib', 'fi_value/formatters/DateFormatter');

class TimeFormatter extends DateFormatter {
	protected $_format = TIME;
}

?>
