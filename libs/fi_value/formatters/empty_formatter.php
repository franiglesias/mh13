<?php
App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* Returns the $this->_format value instead of the current value
*/
	class EmptyFormatter extends FiFormatter
	{
		public function format()
		{
			if ($this->original()) {
				return $this->_Value->get();
			}
			return $this->_format;
		}		
	}


?>
