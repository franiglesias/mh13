<?php
class DeviceTypesController extends ItAppController {
	var $name = 'DeviceTypes';

	function index() {
		$this->set('deviceTypes', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}
	
	public function edit($id = null) {
		// Data needed to load or reload model
		$fields = null;
		// Second pass
		if (!empty($this->data['DeviceType'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->DeviceType->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->DeviceType->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->preserveAppData();
				if (!($this->data = $this->DeviceType->read($fields, $id))) {
					$this->message('error');
					$this->xredirect(); // forget stored referer and redirect
				}
				$this->restoreAppData();
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['DeviceType'])) { // 1st pass
			if ($id) {
				$this->preserveAppData();
				if (!($this->data = $this->DeviceType->read($fields, $id))) {
					$this->message('error');
					$this->xredirect(); // forget stored referer and redirect
				}
				$this->restoreAppData();
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
	}

}
?>