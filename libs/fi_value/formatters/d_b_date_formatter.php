<?php
App::import('Lib', 'fi_value/formatters/DateFormatter');

	class DBDateFormatter extends DateFormatter {
		
		protected $_format = 'Ymd';
		
	}

?>
