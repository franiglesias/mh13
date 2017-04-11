<?php

App::import('Lib', 'events/FiSubject');

class EventManager implements FiSubject
{
	private $observers;
	private $messages;
	
	public function __construct(SplObjectStorage $Storage)
	{
        $this->observers = $Storage;
		$this->messages = array();
	}
	
	public function attach(FiObserver $Observer)
	{
		$this->observers->attach($Observer);
		$eventsSupported = $Observer->getEvents();
		$this->messages = array_merge($this->messages, $eventsSupported);
	}
	
	public function detach(FiObserver $Observer)
	{
		$this->observers->detach($Observer);
	}
	
	public function notify($Generator, $message)
	{
		if (!in_array($message, $this->messages)) {
			return false;
		}
		foreach ($this->observers as $observer) {
 			$observer->update($Generator, $message);
		}
	}
}
	
?>
