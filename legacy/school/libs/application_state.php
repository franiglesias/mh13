<?php
App::import('Lib', 'fi_states/StateFactory');
App::import('Lib', 'fi_states/StateException');
App::import('Model', 'School.Application');

interface ApplicationState {
	public function next(Application $Application, $id = null);
	public function reject(Application $Application, $id = null);
}

abstract class AbstractApplicationState implements ApplicationState {
	public function next(Application $Application, $id = null)
	{
		throw new StateException('Application transition not allowed', 1);
	}

	public function reject(Application $Application, $id = null)
	{
		throw new StateException('Application transition not allowed', 1);
	}
	
}


?>