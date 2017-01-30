<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');
/**
* Removes some dangerous HTML tags from a string
*/
class CleanFormatter extends FiFormatter
{
	public function format()
	{
		$params = array('script', 'iframe', 'object', 'param');
		$str = $this->_Value->get();

		for ($i = 1, $count = count($params); $i < $count; $i++) {
			$str = preg_replace('/<' . $params[$i] . '\b[^>]*>/i', '', $str);
			$str = preg_replace('/<\/' . $params[$i] . '[^>]*>/i', '', $str);
		}
		return $str;
	}
}


?>
