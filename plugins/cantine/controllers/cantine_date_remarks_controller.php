<?php
class CantineDateRemarksController extends CantineAppController {

	var $name = 'CantineDateRemarks';

	function index() {
		$this->CantineDateRemark->recursive = 0;
		$this->paginate['CantineDateRemark']['order'] = array('date' => 'desc');
		$this->paginate['CantineDateRemark']['conditions'] = array('date >= CURDATE()');
		$this->set('cantineDateRemarks', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}
	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['CantineDateRemark'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->CantineDateRemark->create();
			}
			// Try to save
			if ($this->CantineDateRemark->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		// First pass or reload
		if(empty($this->data['CantineDateRemark'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		if (!($this->data = $this->CantineDateRemark->read(null, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

}
?>