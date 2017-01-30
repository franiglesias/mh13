<?php
/**
 * Permissions Controller
 * 
 * Manages Permissions
 *
 * @package access.mh13
 * @version $Rev: 2670 $
 * @license MIT License
 * 
 * $Id: permissions_controller.php 2670 2013-07-31 14:07:33Z franiglesias $
 * 
 * $HeadURL: http://franiglesias@subversion.assembla.com/svn/milhojas/branches/mh13/plugins/access/controllers/permissions_controller.php $
 * 
 **/




class PermissionsController extends AccessAppController {

	var $name = 'Permissions';
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('autocomplete');
	}
	function index() {
		$this->paginate['Permission']['fields'] = array(
			'id', 
			'description', 
			'url_pattern', 
			'access'
			);
		$this->set('permissions', $this->paginate());
	}

	function add($role_id = null) {
		
		$this->setAction('edit', null, $role_id);
	}

	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['Permission'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Permission->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->Permission->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['Permission'])) { // 1st pass
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
		if (!($this->data = $this->Permission->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}
	
	public function autocomplete()
	{
		Configure::write('debug', 0);
		$this->set('permissions', $this->Permission->getAutocomplete($this->params['url']['term']));
		$this->render('ajax/autocomplete', 'ajax');
	}
}

?>