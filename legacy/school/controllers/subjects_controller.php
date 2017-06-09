<?php
class SubjectsController extends SchoolAppController {

	var $name = 'Subjects';
	var $layout = 'backend';
	
	function index() {
		
		$this->Subject->recursive = 0;
		$this->set('subjects', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}

	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['Subject'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Subject->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->Subject->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['Subject'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$fields = null;
		if (!($this->data = $this->Subject->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

}
?>