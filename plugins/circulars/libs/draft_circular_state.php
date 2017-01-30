<?php

App::import('Lib', 'Circulars.CircularState');

/**
* 
*/
class DraftCircularState extends AbstractCircularState
{
	public function next(Circular $Circular, $publisher_id, $id = null)
	{
		$Circular->setId($id);
		$Circular->setToPublished($publisher_id);
		
		$Circular->requestAction(array(
			'plugin' => 'circulars',
			'controller' => 'circulars',
			'action' => 'generate'
		), array(
			'passed' => $id,
			'return' => false
		));
		
	}
	

}


?>