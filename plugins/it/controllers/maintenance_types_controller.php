<?php
class MaintenanceTypesController extends ItAppController {

	var $name = 'MaintenanceTypes';
	
	var $layout = 'backend';

	function index() {
		
		$this->MaintenanceType->recursive = 0;
		$this->set('maintenanceTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('it', 'maintenance type', true)), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('maintenanceType', $this->MaintenanceType->read(null, $id));
	}

	function add() {
		$this->setAction('edit');
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->MaintenanceType->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			if ($this->MaintenanceType->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved.', true), __d('it', 'maintenance type', true)), 'flash_success');
				$this->xredirect();
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __d('it', 'maintenance type', true)), 'flash_validation');
			}
		}
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->MaintenanceType->read($fields, $id))) {
					$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('it', 'maintenance type', true)), 'flash_error');
					$this->xredirect();
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}

}
?>