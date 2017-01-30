<?php

/**
* 
*/
class ClosedApplicationState extends AbstractApplicationState
{
	public function next(Application $Application, $id = null)
	{
		$Application->open($id);
	}
}


?>