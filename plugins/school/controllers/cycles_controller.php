<?php
class CyclesController extends SchoolAppController 
{
	var $name = 'Cycles';
	var $layout = 'backend';

	function index() {
		
		$this->Cycle->recursive = 0;
		$this->set('cycles', $this->paginate());
		$this->set('coordinators', $this->Cycle->findCoordinators());
	}

	function add() {
		$this->setAction('edit');
	}

	public function edit($id = null) 
	{
		// Data needed to load or reload model
		// Second pass
		if (!empty($this->data['Cycle'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Cycle->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->Cycle->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['Cycle'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		$this->set('coordinators', $this->Cycle->findCoordinators());
	}

	public function refreshModel($id)
	{
		$this->preserveAppData();
		if (!($this->data = $this->Cycle->read(null, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}
}
?>