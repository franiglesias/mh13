<?php


/**
 * FileDispatcherInterface
 * 
 * A class able to move a File from one location to another based in certain rules
 *
 * @package default
 * @author Fran Iglesias
 */

interface FileDispatcherInterface {
	/**
	 * Moves a file to its destination
	 *
	 * @param DispatchedFileInterface $File 
	 * @param string $options 
	 * @return 
	 * @author Fran Iglesias
	 */
	public function dispatch(DispatchedFileInterface $File, $options = array('move' => 'route'));
	/**
	 * Adds a subfolder for a specific base type of file
	 *
	 * @param string $type the type (i.e: image)
	 * @param string $folder (i.e.: img)
	 * @return void
	 * @author Fran Iglesias
	 */
	public function addTypeRoute($type, $folder);
	/**
	 * Adds a subfolder
	 *
	 * @param string $folder (i.e.: article)
	 * @return void
	 * @author Fran Iglesias
	 */
	public function addSubRoute($folder);
	/**
	 * (fluent) Dispatched move the file, deleting source
	 *
	 * Fluent example:
	 * $Dispatcher->move()->dispatch($File);
	 *
	 * $Dispatcher->move();
	 * $Dispatcher->dispatch($File);
	 *
	 * @return $this
	 * @author Fran Iglesias
	 */
	public function move();
	/**
	 * (fluent) Dispatcher copies the file, leaving source in its place
	 *
	 * Fluent example:
	 * $Dispatcher->copy()->dispatch($File);
	 *
	 * $Dispatcher->copy();
	 * $Dispatcher->dispatch($File);
	 *
	 * @return $this
	 * @author Fran Iglesias
	 */
	public function copy();
}

?>
