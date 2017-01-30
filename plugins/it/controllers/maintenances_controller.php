<?php

App::import('Lib', 'It.MaintenanceState');

class MaintenancesController extends ItAppController {

	var $name = 'Maintenances';
	var $components = array(
		'Filters.SimpleFilters',
		'State' => array(
			'It.Maintenance' => array(
				Maintenance::OPEN => 'OpenMaintenanceState',
				Maintenance::SAT => 'SatMaintenanceState',
				Maintenance::INTERNAL => 'InternalMaintenanceState',
				Maintenance::RESOLVED => 'ResolvedMaintenanceState',
				Maintenance::UNRESOLVED => 'UnresolvedMaintenanceState',
				)
			)
		);
	var $helpers = array('It.Maintenance', 'Ui.XHtml');

	function index($device_id = null) {
		if (!empty($device_id)) {
			$this->paginate['Maintenance']['conditions'] = array('Maintenance.device_id' => $device_id);
		}
		$this->paginate['Maintenance'][0] = 'index';
		$this->set('maintenances', $this->paginate());
		$this->_setCommonOptions();
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/index', 'ajax');
		}
	}

	function add($device_id = null) {
		$this->Maintenance->create();
		$this->Maintenance->set(array(
			'device_id' => $device_id,
			'status' => 0
		));
		$this->Maintenance->save(null, false);
		$this->setAction('edit', $this->Maintenance->getLastInsertId(), $device_id);
	}
		
	function edit($id = null, $device_id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->Maintenance->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			if ($this->Maintenance->save($this->data)) {
				$this->message('success');
				if ($this->RequestHandler->isAjax()) {
					$this->redirect(array('action' => 'index', $this->data['Maintenance']['device_id']));
				}
				$this->xredirect();
			} else {
				$this->message('validation');
			}
		}
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Maintenance->read($fields, $id))) {
					$this->message('invalid');
					$this->xredirect();
				}
			} else {
				$this->data['Maintenance']['device_id'] = $device_id;
				$this->data['Maintenance']['status'] = 0;
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		$this->_setCommonOptions();
		if ($this->RequestHandler->isAjax()) {
			$this->render('ajax/edit', 'ajax');
		}
	}

	function delete($id = null) {
		$this->Maintenance->id = $id;
		$device_id = $this->Maintenance->field('device_id');
		if (!$this->Maintenance->delete($id)) {
			$this->message('error');
		} else {
			$this->message('delete');
		}
		if ($this->RequestHandler->isAjax()) {
			$this->redirect(array('action' => 'index', $device_id));
		}
		$this->redirect($this->referer());
	}
	
	public function report()
	{
		if (empty($this->paginate['Maintenance'])) {
			$this->paginate['Maintenance'] = array();
		}
		$report = $this->Maintenance->find('response', $this->paginate['Maintenance']);
		$this->set('range', $this->SimpleFilters->getFilter('Maintenance.requested'));
		$this->set(compact('report'));
	}
	
	public function _setCommonOptions() {
		$this->set('devices', $this->Maintenance->Device->find('list'));
		$this->set('technicians', $this->Maintenance->Technician->find('list'));
		$this->set('maintenanceTypes', $this->Maintenance->MaintenanceType->find('list'));
	}
	
	public function reopen($id)
	{
		$data = $this->Maintenance->read(array('status'), $id);
		$State = $this->State->get($data['Maintenance']['status']);
		$State->reopen($this->Maintenance, $id);
		$this->redirect(array('action' => 'edit', $id));
	}

	
	public function send($id)
	{
		$data = $this->Maintenance->read(array('status', 'technician_id'), $id);
		extract($data['Maintenance']);
		$State = $this->State->get($data['Maintenance']['status']);
		$State->send($this->Maintenance, $technician_id, $id);
		$this->redirect(array('action' => 'edit', $id));
	}
	
	public function retire($id)
	{
		$data = $this->Maintenance->read(array('status'), $id);
		$State = $this->State->get($data['Maintenance']['status']);
		$State->retire($this->Maintenance, $id);
		$this->redirect(array('action' => 'edit', $id));
	}
	
	public function repair($id)
	{
		$data = $this->Maintenance->read(array('status'), $id);
		$State = $this->State->get($data['Maintenance']['status']);
		$State->repair($this->Maintenance, $id);
		$this->redirect(array('action' => 'edit', $id));
	}

	
	public function restore($id)
	{
		$data = $this->Maintenance->read(array('status'), $id);
		$State = $this->State->get($data['Maintenance']['status']);
		$State->restore($this->Maintenance, $id);
		$this->redirect(array('action' => 'edit', $id));
	}

}
?>