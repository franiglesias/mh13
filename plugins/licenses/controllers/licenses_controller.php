<?php

class LicensesController extends LicensesAppController {

	var $name = 'Licenses';
	var $helpers = array('Ui.Table', 'Licenses.Licenses', 'Licenses.License');
	var $layout = 'backend';
	
	public function beforeFilter() {

		parent::beforeFilter();
		$this->selectionActions = array(
			'selectionDelete' => __('Delete', true)
		);
	}
	
	public function index()
	{
		$this->paginate['License']['order'] = array('License.license' => 'asc');
		$this->set('licenses', $this->paginate('License'));
	}

	public function add() {
		$this->License->create();
		$this->License->save(false, null);
		$this->setAction('edit', $this->License->id);
	}
	
	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['License'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->License->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->License->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['License'])) { // 1st pass
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
		if (!($this->data = $this->License->read(null, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}
	

/**
 * Selection actions
 *
 * @param string $ids 
 * @return void
 */
	protected function _selectionDelete($ids) {
		$this->License->deleteAll(array('License.id' => $ids));
        $this->Session->setFlash(
            sprintf(__('Selected %s deleted', true), __d('licenses', 'Licenses', true)),
            'success'
        );
	}
}
?>