<?php

/**
* 
*/
class ReceivedApplicationState extends AbstractApplicationState
{
	public function next(Application $Application, $id = null)
	{
		$Application->open($id);
	}
}


?>