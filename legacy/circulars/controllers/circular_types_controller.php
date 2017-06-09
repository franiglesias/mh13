<?php
class CircularTypesController extends CircularsAppController {

	var $name = 'CircularTypes';
	var $layout = 'backend';
	
	function index() {
		
		$this->CircularType->recursive = 0;
		$this->set('circularTypes', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}
	
	public function edit($id = null) {
		// Data needed to load or reload model
		$fields = null;
		// Second pass
		if (!empty($this->data['CircularType'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->CircularType->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->CircularType->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['CircularType'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
	}
	
	private function refreshModel($id)
	{
		$this->preserveAppData();
		if (!($this->data = $this->CircularType->read(null, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();

	}

}
?>