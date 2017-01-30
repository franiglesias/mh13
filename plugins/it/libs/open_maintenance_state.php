<?php

App::import('Lib', 'It.MaintenanceState');

class OpenMaintenanceState extends AbstractMaintenanceState
{
	public function repair(Maintenance $Maintenance, $id = null)
	{
		$Maintenance->setId($id);
		$Maintenance->saveField('status', Maintenance::INTERNAL);
		$Maintenance->addHistory('Open Maintenance action.');
		$Maintenance->Device->repair($Maintenance->field('device_id'));
	}

	public function send(Maintenance $Maintenance, $technician_id, $id = null)
	{
		$Maintenance->setId($id);
		$Maintenance->saveField('status', Maintenance::SAT);
		$Maintenance->saveField('technician_id', $technician_id);
		$Maintenance->addHistory('Sent to external SAT.');
		$Maintenance->Device->send($Maintenance->field('device_id'));
	}
	

}


?>