<?php

class AbstractObserver implements FiObserver
{
	private $implemented;

	public function listen($message, $method)
	{
		$this->implemented[$message] = $method;
	}

	public function update($Generator, $message)
	{
		if (!array_key_exists($message, $this->implemented)) {
			return false;
		}
		$method = $this->implemented[$message];
		if (!method_exists($this, $method)) {
			throw new BadMethodCallException(get_class().'->'.$method.' Not implemented');
		}
		$this->$method($Generator);
	}
	
	public function getEvents()
	{
		return array_keys($this->implemented);
	}
	
	public function log($message, $log = 'debug')
	{
		file_put_contents(LOGS.$log.'.log', date('Y-m-d H:i > ').$message.chr(10), FILE_APPEND);
	}
	
}

?>