<?php

/**
 * Implements DataProvider Interface
 *
 * @package default
 * @author Fran Iglesias
 */
App::import('Lib', 'data_provider/abstracts/AbstractDataProvider');
App::import('Lib', 'data_provider/interfaces/PlainDataProvider');

abstract class SingleDataProvider extends AbstractDataProvider implements PlainDataProvider{
	
	public function countKey($key)
	{
		if (!$this->hasKey($key)) {
			return false;
		}
		if($this->isAssoc($key)) {
			return 1;
		}
		return count($this->_source[$key]);
	}
	
	// public function connectRelated(&$DP, $key)
	// {
	// 	if (!$this->hasKey($key)) {
	// 		throw new InvalidArgumentException($key.' Model not present in data array');
	// 	}
	// 	if($this->isAssoc($key)) {
	// 		$DP->bind($this->source())->useModel($key);
	// 		return;
	// 	}
	// 	$DP->bind($this->_source[$key]);
	// }
	
	private function isAssoc($key)
	{
		return count(array_filter(array_keys($this->_source[$key]), 'is_string')) > 0;
	}

}

?>
