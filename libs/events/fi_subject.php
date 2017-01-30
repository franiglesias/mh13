<?php
interface FiSubject
{
	public function attach(FiObserver $Observer);
	public function detach(FiObserver $Observer);
	public function notify($Generator, $message);
}

?>
