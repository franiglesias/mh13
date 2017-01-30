<?php

class RelativeFormatter extends FiFormatter
{
	public function format()
	{
		if ($this->_format) {
			$now = strtotime($this->_format);
		} else {
			$now = time();
		}
		$days = intval(($now - strtotime($this->_Value->get())) / 86400);
		if ($days === 0) {
			return __('Today', true);
		}
		if ($days == 1) {
			return __('Yesterday', true);
		}
		if ($this->isBetween($days, 2, 6)) {
			return sprintf(__('%s days ago', true), $days);
		}
		if ($this->isBetween($days, 7, 13)) {
			return sprintf(__('Last week', true));
		}
		if ($this->isBetween($days, 14, 20)) {
			return sprintf(__('2 weeks ago', true));
		}
		if ($this->isBetween($days, 21, 27)) {
			return sprintf(__('3 weeks ago', true));
		}
		if ($this->isBetween($days, 28, 34)) {
			return sprintf(__('A month ago', true));
		}
		
		return $this->_Value->get();
	}
	
	private function isBetween($value, $min, $max)
	{
		if ($value >= $min && $value <= $max) {
			return true;
		}
		return false;
	}
}

?>
