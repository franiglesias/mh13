<?php

/**
 * FiValue class have a get method to return the value they store
 *
 * @package default
 * @author Fran Iglesias
 */
interface FiValue {
	/**
	 * Returns the value
	 *
	 * @return mixed Stored value
	 */
	public function get();
	public function set($value);
}

?>