<?php


/**
* 
*/
class SimpleIterator
{
	/**
	 * The internal pointer of the Iterator
	 *
	 * @var integer
	 */
	protected $pointer = null;
	/**
	 * A reference to the array that this iterator traverse
	 *
	 * @var object
	 */
	protected $dataSet = null;
	
	/**
	 * Constructor
	 *
	 * @param reference $object The object 
	 * @param string $dataSet The name of the dataSet property of the object
	 * @param string $data The name of the data property of the object
	 */
	function __construct(&$dataSet = null)
	{
		$this->bind($dataSet);
	}
	
	public function bind(&$dataSet)
	{
		$this->dataSet =& $dataSet;
		if ($this->count()) {
			$this->rewind();
		}
	}
	/**
	 * Returns the number of items in the Iterated Object
	 * Upper limit of the Iterator
	 *
	 * @return integer
	 */
	public function count()
	{
		if (is_null($this->dataSet)) {
			return $this->pointer = null;
		}
		return count($this->dataSet);
	}
	/**
	 * Without arguments: Returns the current value of the Iterator pointer
	 * With arguments: Sets a new pointer value
	 * @param optional integer $newPointer 
	 * @return integer the current pointer
	 */
	public function pointer($newPointer = null)
	{
		if (is_null($newPointer)) {
			return $this->pointer;
		}
		if ($newPointer === false) {
			throw new InvalidArgumentException('New pointer should be an integer value', 1);
			
		}
		if ($this->outOfBounds($newPointer)) {
			throw new OutOfBoundsException("Invalid value for Iterator pointer", 1);
		}
		return $this->pointer = $newPointer;
	}
	
	private function outOfBounds($newPointer)
	{
		return $newPointer < 0 || $newPointer >= $this->count();
	}
	/**
	 * Moves the pointer to the first item in the dataSet
	 *
	 * @return integer current pointer value (0)
	 * @author Fran Iglesias
	 */
	public function rewind()
	{
		return $this->pointer = -1;
	}

	public function first()
	{
		return $this->rewind();
	}

	/**
	 * Sets the pointer to the next item in the dataset
	 *
	 * @return integer new current pointer value
	 */
	public function next()
	{
		if ($this->hasNext()) {
			return $this->pointer += 1;
		} 
		return $this->pointer = null;
	}
	/**
	 * Returns the iteration value, the "natural" or "human readaable" index of the current element
	 * 
	 * @return integer
	 */
	public function iteration()
	{
		if (is_null($this->pointer)) {
			return null;
		}
		return $this->pointer + 1;
	}
	/**
	 * undocumented function
	 *
	 * @return boolean true if there are items in the list
	 * @author Fran Iglesias
	 */
	
	public function hasNext()
	{
		if (is_null($this->pointer) || !$this->count()) {
			return false;
		}
		return $this->pointer < ($this->count() - 1);
	}
	
	public function remains()
	{
		return $this->hasNext();
	}

	public function &current()
	{
		if ($this->outOfBounds($this->pointer)) {
			throw new OutOfBoundsException('Iterator Invalid pointer', 1);
		}
		return $this->dataSet[$this->pointer()];
	}
	
}

?>