<?php 
/**
 * Data provider binds a Presentation Model with a variable that contains data for a certain entity
 *
 * @package default
 * @author Fran Iglesias
 */
interface DataProvider {

	# Data Binding
	
	/**
	 * Binds the DataProvider with a var
	 *
	 * @param mixed $var The var to bind. $null creates the DP without binding
	 * @return boolean true on success
	 */
	public function bind(&$var);

	/**
	 * Unbinds DataProvider and var
	 *
	 * @return void
	 */
	public function unbind();

	/**
	 * Returns true if the DataProvider is bound to a valid var
	 *
	 * @return boolean
	 */
	public function bound();

	# Data Access Methods
	
	/**
	 * Returns a reference to the source of the Data Provider
	 * @param if $key is provided returns the reference to the Key in source
	 * @return Reference
	 */
	public function &source($key = false);

	/**
	 * Returns a copy of data managed by DataProvider
	 *
	 * @return array
	 */
	public function dataSet();

	/**
	 * Returns true if the bound var is empty, so the DataProvider is empty
	 *
	 * @return boolean true if empty
	 */
	public function isEmpty();

	/**
	 * Returns a DataProvider for the given Key
	 *
	 * @param string $key 
	 * @return reference to a Data Provider
	 */
	public function getKeyDataProvider($key);

	/**
	 * Return full data for the given Key
	 *
	 * @param string $key 
	 * @return array
	 */
	public function getKeyDataSet($key);
}

?>