<?php
// A type of DataProvider that uses an associative array (map, dictionary...)
interface PlainDataProvider{
	/**
	 * Is there a $field in the bound var?
	 *
	 * @param string $field 
	 * @return boolean
	 */
	public function hasField($field);
	/**
	 * Returns the value of a field key in the bound view var
	 *
	 * @param string $field 
	 * @return mixed
	 */
	public function value($field);
}

?>