<?php
App::import('Lib', 'fi_states/StateFactory');
App::import('Lib', 'fi_states/StateException');
App::import('Model', 'It.Maintenance');

interface MaintenanceState {
	public function send(Maintenance $Maintenance, $technician_id, $id = null);
	public function repair(Maintenance $Maintenance, $id = null);
	public function retire(Maintenance $Maintenance, $id = null);
	public function restore(Maintenance $Maintenance, $id = null);
	public function reopen(Maintenance $Maintenance, $id = null);
}

abstract class AbstractMaintenanceState implements MaintenanceState
{
	public function repair(Maintenance $Maintenance, $id = null)
	{
		throw new StateException(get_class().': Maintenance transition repair not allowed', 1);
	}

	public function send(Maintenance $Maintenance, $technician_id, $id = null)
	{
		throw new StateException(get_class().': Maintenance transition send not allowed', 1);
	}
	public function retire(Maintenance $Maintenance, $id = null)
	{
		throw new StateException(get_class().': Maintenance transition retire not allowed', 1);
	}
	public function restore(Maintenance $Maintenance, $id = null)
	{
		throw new StateException(get_class().': Maintenance transition restore not allowed', 1);
	}
	public function reopen(Maintenance $Maintenance, $id = null)
	{
		throw new StateException('Maintenance transition reopen not allowed', 1);
	}
}

?>