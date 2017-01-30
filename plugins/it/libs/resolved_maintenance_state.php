<?php
App::import('Lib', 'It.MaintenanceState');

class ResolvedMaintenanceState extends AbstractMaintenanceState
{
	
	public function reopen(Maintenance $Maintenance, $id = null)
	{
		$Maintenance->setId($id);
		$Maintenance->saveField('status', Maintenance::OPEN);
		$Maintenance->saveField('resolved', null);
		$Maintenance->addHistory('Maintenance Action Opened');
		$Maintenance->Device->open($Maintenance->field('device_id'));		
	}

}


?>