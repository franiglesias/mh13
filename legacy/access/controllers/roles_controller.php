<?php
class RolesController extends AccessAppController {

	var $name = 'Roles';
	var $components = array('Filters.SimpleFilters');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		// $this->Auth->allow('index', 'add', 'edit', 'delete');
	}

	function index() {
		$this->set('roles', $this->paginate());
	}

	function add() {
		$this->Role->init();
		$this->setAction('edit', $this->Role->getID());
	}

	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['Role'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Role->create();
			}
			// Try to save
			if ($this->Role->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['Role'])) { // 1st pass
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
		if (!($this->data = $this->Role->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

}
?>