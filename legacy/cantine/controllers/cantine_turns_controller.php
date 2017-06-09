<?php
class CantineTurnsController extends CantineAppController {

	var $name = 'CantineTurns';

	function index() {
		
		$this->CantineTurn->recursive = 0;
		$this->paginate['CantineTurn']['order'] = array('slot' => 'asc');
		$this->set('cantineTurns', $this->paginate());
	}

	function add() {
		$this->CantineTurn->create();
		$this->CantineTurn->save(null, false, false);
		$this->setAction('edit', $this->CantineTurn->getID());
	}
	
	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['CantineTurn'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->CantineTurn->create();
			}
			// Try to save
			if ($this->CantineTurn->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['CantineTurn'])) { // 1st pass
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
		$this->CantineTurn->contain('CantineRule');
		if (!($this->data = $this->CantineTurn->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

}
?>