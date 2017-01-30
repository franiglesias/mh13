<?php
App::import('Lib', 'fi_value/formatters/DateFormatter');

class ShortDateFormatter extends DateFormatter {
	protected $_format = DATE_EXTRA_SHORT;
}

?>
