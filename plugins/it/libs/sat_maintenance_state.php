<?php
App::import('Lib', 'It.MaintenanceState');

class SatMaintenanceState extends AbstractMaintenanceState
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
	

}


?>