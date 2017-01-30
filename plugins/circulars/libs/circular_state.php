<?php
App::import('Lib', 'fi_states/StateFactory');
App::import('Lib', 'fi_states/StateException');
App::import('Model', 'Circulars.Circular');

interface CircularState {
	public function draft(Circular $Circular, $publisher_id, $id = null);
	public function next(Circular $Circular, $publisher_id, $id = null);
	public function revoke(Circular $Circular, $publisher_id, $id = null);
}

abstract class AbstractCircularState implements CircularState {
	public function draft(Circular $Circular, $publisher_id, $id = null)
	{
		throw new StateException('Circular transition not allowed', 1);
	}
	
	public function next(Circular $Circular, $publisher_id, $id = null)
	{
		throw new StateException('Circular transition not allowed', 1);
	}
		
	public function revoke(Circular $Circular, $publisher_id, $id = null)
	{
		throw new StateException('Circular transition not allowed', 1);
	}
}

?>