<?php
App::import('Lib', 'It.MaintenanceState');

class InternalMaintenanceState extends AbstractMaintenanceState
{
	
	public function restore(Maintenance $Maintenance, $id = null)
	{
		$Maintenance->setId($id);
		$Maintenance->saveField('status', Maintenance::RESOLVED);
		$Maintenance->saveField('resolved', date('Y-m-d'));
		$Maintenance->addHistory('Closed Resolved');
		
		$Maintenance->Device->restore($Maintenance->field('device_id'));
	}
	
	public function retire(Maintenance $Maintenance, $id = null)
	{
		$Maintenance->setId($id);
		$Maintenance->saveField('status', Maintenance::UNRESOLVED);
		$Maintenance->saveField('resolved', date('Y-m-d'));
		$Maintenance->addHistory('Closed unresolved. Device will be retired.');
		$Maintenance->Device->retire($Maintenance->field('device_id'));
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