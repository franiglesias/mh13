<?php
class PrizesController extends RafflesAppController {

	var $name = 'Prizes';
	var $layout = 'backend';
	var $components = array('Filters.SimpleFilters');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array('check', 'sponsors', 'prizelist'));
	}

	public function index() {
		$this->set('prizes', $this->paginate());
	}

	public function official() {
		$this->set('prizes', $this->Prize->findAll());
	}
	
	public function prizelist($sponsor = null)
	{
		$this->layout = 'basic';
		$this->set('prizes', $this->Prize->findAll());
	}

	function add() {
		$this->setAction('edit');
	}

	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['Prize'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Prize->create();
			}
			if ($this->Prize->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		if(empty($this->data['Prize'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		if (!($this->data = $this->Prize->read(null, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}
	
	public function check()
	{
		$this->layout = 'basic';
		if (!empty($this->data['Prize'])) {
			// Try to save data, if it fails, retry
			if ($result = $this->Prize->findByNumber($this->data['Prize']['number'])) {
 				$this->set(compact('result'));
			} else {
				$this->set('ticket', $this->data['Prize']['number']);
				$this->set('result', false);
			}
		}
		if (empty($this->data['Prize'])) { // 1st pass
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		
	}
	
	public function sponsors()
	{
		if (empty($this->params['requested'])) {
			$this->redirect('/');
		}
		return $this->Prize->getSponsors();
	}
	
}
?>