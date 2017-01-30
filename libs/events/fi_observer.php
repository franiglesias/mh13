<?php

interface FiObserver{
	/**
	 * Run the method registered to proccess the message and get the message Generator
	 *
	 * @param string $Generator 
	 * @param string $message 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function update($Generator, $message);
	/**
	 * Return a list of messages/events supported by the observer
	 *
	 * @return array
	 * @author Fran Iglesias
	 */
	public function getEvents();
}

?>