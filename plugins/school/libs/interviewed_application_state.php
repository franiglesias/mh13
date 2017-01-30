<?php

/**
* 
*/
class InterviewedApplicationState extends AbstractApplicationState
{
	public function next(Application $Application, $id = null)
	{
		$Application->accept($id);
	}
	
	public function reject(Application $Application, $id = null)
	{
		$Application->reject($id);
	}
	
}


?>