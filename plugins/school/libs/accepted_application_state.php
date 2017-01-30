<?php

/**
* 
*/
class AcceptedApplicationState extends AbstractApplicationState
{
	public function next(Application $Application, $id = null)
	{
		$Application->confirm($id);
	}
	
	public function reject(Application $Application, $id = null)
	{
		$Application->noConfirm($id);
	}
	
}


?>