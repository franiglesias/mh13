<?php
/**
 * PermissionsRolesController
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class PermissionsRolesController extends AccessAppController {
	
	var $name = 'PermissionsRoles';

	var $helpers = array('Html', 'Form', 'Ui.FForm');
	
	function beforeFilter() {
		parent::beforeFilter();
		// $this->Auth->allow('index',  'edit', 'add');
	}

	
	/**
	 * Index action
	 *
	 * @access public
	 */
	function index($roleId = null) {
		// $this->PermissionsRole->recursive = 0;
		$this->paginate['PermissionsRole']['conditions'] = array(
			'role_id' => $roleId
		);
		$permissionsList = $this->PermissionsRole->Permission->find('list');
		$this->set('permissionsList', $permissionsList);
		$this->set('PermissionsRoles', $this->paginate());
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/index', 'ajax');
		}
	}
	
	
	/**
	 * Add action
	 *
	 * @access public
	 */
	function add($roleId = null) {
		$id = $this->PermissionsRole->init($roleId);
		$this->setAction('edit', $id, $roleId);
	}
	

	public function edit($id = null, $roleId = null) 
	{
		// Second pass
		if (!empty($this->data['PermissionsRole'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->PermissionsRole->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->PermissionsRole->save($this->data)) {
				$this->message('success');
				if ($this->RequestHandler->isAjax()) {
					$this->redirect(array('action' => 'index', $this->data['PermissionsRole']['role_id']));
				}
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['PermissionsRole'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
		$permissionsList = $this->PermissionsRole->Permission->find('list');
		$this->set('permissionsList', $permissionsList);
		
		
		if ($this->RequestHandler->isAjax()) {
			$this->render('ajax/edit', 'ajax');
		}
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$fields = null;
		if (!($this->data = $this->PermissionsRole->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}
	/**
	 * Delete action
	 *
	 * @access public
	 * @param integer $id ID of record
	 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PermissionsRole', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PermissionsRole->delete($id)) {
			$this->Session->setFlash(__('PermissionsRole deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('PermissionsRole was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>