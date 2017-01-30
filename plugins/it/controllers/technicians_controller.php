<?php
class TechniciansController extends ItAppController {

	var $name = 'Technicians';
	
	

	function index() {
		
		$this->Technician->recursive = 0;
		$this->set('technicians', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
 
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('it', 'technician', true)), 'flash_error');
			$this->redirect(array('action' => 'index'));
 
		}
		$this->set('technician', $this->Technician->read(null, $id));
	}

	function add() {
		$this->setAction('edit');
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->Technician->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			if ($this->Technician->save($this->data)) {
 
				$this->Session->setFlash(sprintf(__('The %s has been saved.', true), __d('it', 'technician', true)), 'flash_success');
				$this->xredirect();
 
			} else {
 
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __d('it', 'technician', true)), 'flash_validation');
 
			}
		}
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Technician->read($fields, $id))) {
					 
					$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('it', 'technician', true)), 'flash_error');
					$this->xredirect();
					 
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}

}
?>