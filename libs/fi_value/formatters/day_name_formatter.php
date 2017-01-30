<?php
App::import('Lib', 'fi_value/formatters/DateFormatter');
	class DayNameFormatter extends DateFormatter {
		
		protected $_format = 'l';
	}

?>
