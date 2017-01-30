<?php
class CantineWeekMenusController extends CantineAppController {

	var $name = 'CantineWeekMenus';
	
	var $helpers = array('Cantine.Cantine');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array(
				'today'
				)
			);
	}

	function index() {
		$this->CantineWeekMenu->recursive = 0;
		$this->paginate['CantineWeekMenu']['order'] = array('id' => 'desc');
		$this->set('cantineWeekMenus', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}

	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['CantineWeekMenu'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->CantineWeekMenu->create();
			}
			// Try to save
			if ($this->CantineWeekMenu->saveAll($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['CantineWeekMenu'])) { // 1st pass
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
		$this->CantineWeekMenu->contain('CantineDayMenu', 'CantineMenuDate');
		if (!($this->data = $this->CantineWeekMenu->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

}
?>