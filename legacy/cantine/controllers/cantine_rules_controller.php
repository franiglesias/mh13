<?php
class CantineRulesController extends CantineAppController {

	var $name = 'CantineRules';
	
	public function beforeRender()
	{
		parent::beforeRender();
		if ($this->RequestHandler->isAjax()) {
			$this->Auth->allow(array('rotate1', 'rotate2'));
		}
	}

	function index($cantine_turn_id = null) {
		
		$this->CantineRule->recursive = 0;
		if (!empty($cantine_turn_id)) {
			$this->paginate['CantineRule']['conditions'] = array(
				'CantineRule.cantine_turn_id' => $cantine_turn_id
			);
		}
		$this->set('cantineRules', $this->paginate('CantineRule'));
		$cantineGroups = $this->CantineRule->CantineGroup->find('list');
		$cantineTurns = $this->CantineRule->CantineTurn->find('list');
		$this->set(compact('cantineGroups', 'cantineTurns'));
		$this->set('states', $this->CantineRule->states);
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/index');
		}		
	}

	function add($cantine_turn_id = false) {
		$this->setAction('edit', null, $cantine_turn_id);
	}

	public function edit($id = null, $cantine_turn_id = false) 
	{
		// Second pass
		if (!empty($this->data['CantineRule'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->CantineRule->create();
			}
			// Try to save
			if ($this->CantineRule->save($this->data)) {
				$this->message('success');
				if ($this->RequestHandler->isAjax()) {
					$this->redirect(array('action' => 'index', $this->data['CantineRule']['cantine_turn_id']));
					$this->autoRender = false;
				}
				
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['CantineRule'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			} else {
				$this->data['CantineRule']['cantine_turn_id'] = $cantine_turn_id;
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
		$cantineTurns = $this->CantineRule->CantineTurn->find('list');
		$sections = $this->CantineRule->Section->find('list');
		$cantineGroups = $this->CantineRule->CantineGroup->find('list');
		$this->set(compact('cantineTurns', 'sections', 'cantineGroups'));
		$this->set('states', $this->CantineRule->states);
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/edit');
		}
		
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$fields = null;
		if (!($this->data = $this->CantineRule->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}
	
	public function rotate1($id)
	{
		if (!$this->RequestHandler->isAjax()) {
			$this->redirect('/');
		}
		list($field, $id) = explode('_', $id);
		$this->CantineRule->rotateField('extra1', 3, $id);
		$this->CantineRule->id = $id;
		$this->set('value', $this->CantineRule->field('extra1'));
		$this->set('values', $this->CantineRule->states);
		$this->set('uid', $id);
		$this->render('ajax/rotate');
	}

	public function rotate2($id)
	{
		if (!$this->RequestHandler->isAjax()) {
			$this->redirect('/');
		}
		list($field, $id) = explode('_', $id);
		$this->CantineRule->rotateField('extra2', 3, $id);
		$this->CantineRule->id = $id;
		$this->set('value', $this->CantineRule->field('extra2'));
		$this->set('values', $this->CantineRule->states);
		$this->set('uid', $id);
		$this->render('ajax/rotate');
	}

	function delete($id = null) {
		$this->CantineRule->id = $id;
		$cantine_turn_id = $this->CantineRule->field('cantine_turn_id');
		if (!$this->CantineRule->delete($id)) {
            $this->Session->setFlash(
                sprintf(__('%s was not deleted.', true), __d('access', 'Cantine Rule', true)),
                'alert'
            );
		} else {
            $this->Session->setFlash(
                sprintf(__('%s was deleted.', true), __d('access', 'Cantine Rule', true)),
                'success'
            );
		}
		if ($this->RequestHandler->isAjax()) {
			$this->redirect(array('action' => 'index', $cantine_turn_id));
		}
		$this->redirect($this->referer());
	}
		
}
?>