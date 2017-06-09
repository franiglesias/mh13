<?php
class CantineGroupsController extends CantineAppController {

	var $name = 'CantineGroups';

	function index() {
		$this->CantineGroup->recursive = 0;
		$this->set('cantineGroups', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}
	
	public function edit($id = null) 
	{
		if (!empty($this->data['CantineGroup'])) {
			if (!$id) {
				$this->CantineGroup->create();
			}
			if ($this->CantineGroup->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['CantineGroup'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		$this->passOptionsToView();
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$this->CantineGroup->retrieve($id);
		$this->data = $this->CantineGroup->data;
		if (!$this->data) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

	private function passOptionsToView()
	{
		$this->set('turns', $this->CantineGroup->CantineRule->CantineTurn->find('list'));
		$this->set('extraOptions', $this->CantineGroup->CantineRule->states);
	}


}
?>