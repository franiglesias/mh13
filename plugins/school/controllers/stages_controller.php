<?php
class StagesController extends SchoolAppController {

	var $name = 'Stages';
	var $layout = 'backend';

	function index() {
		
		$this->Stage->recursive = 0;
		$this->set('stages', $this->paginate());
		$this->set('coordinators', $this->Stage->findCoordinators());
	}

	function add() {
		$this->setAction('edit');
	}
	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['Stage'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Stage->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->Stage->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['Stage'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
		$this->set('coordinators', $this->Stage->findCoordinators());
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$fields = null;
		if (!($this->data = $this->Stage->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

}
?>