<?php
class LevelsController extends SchoolAppController {

	var $name = 'Levels';
	var $layout = 'backend';
	
	function index() {
		
		$this->Level->recursive = 0;
		$this->set('levels', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}

	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['Level'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Level->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->Level->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['Level'])) { // 1st pass
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
		if (!($this->data = $this->Level->read(null, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}
}
?>