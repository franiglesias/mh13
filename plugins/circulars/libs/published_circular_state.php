<?php

App::import('Lib', 'Circulars.CircularState');

class PublishedCircularState extends AbstractCircularState {

	public function draft(Circular $Circular, $publisher_id, $id = null)
	{
		$Circular->setId($id);
		$Circular->setToDraft($publisher_id);
		$Circular->deleteFile($id);
	}
	
	public function next(Circular $Circular, $publisher_id, $id = null)
	{
		$Circular->setId($id);
		$Circular->setToArchived($publisher_id);
	}
	
	public function revoke(Circular $Circular, $publisher_id, $id = null)
	{
		$Circular->setId($id);
		$Circular->setToRevoked($publisher_id);
		$Circular->deleteFile($id);
	}
	
}


?>
