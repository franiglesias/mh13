<?php

/**
* 
*/
class OpenedApplicationState extends AbstractApplicationState
{
	public function next(Application $Application, $id = null)
	{
		$Application->interview($id);
	}
}


?>