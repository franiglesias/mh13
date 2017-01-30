<?php 

// Is a type of DataProvider that uses an array of data and a SingleDataProvider to access it acts as an Iterator
interface MultiDataProvider {
	/**
	 * Attachs a SingleDataProvider to manage elements in the MultiDataProvider
	 *
	 * @param string $Single 
	 * @author Fran Iglesias
	 */
	public function attach(SingleDataProvider &$Single);
	
	# Iterator delegation functions
	
	public function rewind();
	public function next();
	public function hasNext();
	public function &current();
	public function pointer($newPointer = null);
	public function count();
}


?>