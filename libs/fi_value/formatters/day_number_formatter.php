<?php
App::import('Lib', 'fi_value/formatters/DateFormatter');

	class DayNumberFormatter extends DateFormatter {
		protected $_format = 'j';
	}

?>
