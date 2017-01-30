<?php
class MeritTypesController extends ResumesAppController {

	var $name = 'MeritTypes';
	
	var $layout = 'backend';

	function index() {
		$this->MeritType->recursive = 0;
		$this->set('meritTypes', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}
	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['MeritType'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->MeritType->create();
			}
			// Try to save
			if ($this->MeritType->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['MeritType'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$fields = null;
		if (!($this->data = $this->MeritType->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

}
?>