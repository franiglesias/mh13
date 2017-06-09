<?php
/**
 * LabelsController
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class LabelsController extends LabelsAppController {
	/**
	 * The name of this controller. Controller names are plural, named after the model they manipulate.
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'Labels';

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Form', 'Ui.Table');
	var $layout = 'backend';
	
	/**
	 * Array containing the names of components this controller uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	var $components = array();

	public function beforeFilter()
	{
		parent::beforeFilter();
		if($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->Auth->allow('index');
		}
	}
	/**
	 * Index action
	 *
	 * @access public
	 */
	function index($owner_model = false, $owner_id = false) {
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->paginate['Label'][0] = 'model';
			$this->paginate['Label']['model'] = $owner_model;
			$this->paginate['Label']['id'] = $owner_id;
		} else {
			$this->paginate['Label'][0] = 'global';
		}
		$this->set('labels', $this->paginate());
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/index', 'ajax');
		}
	}
	
	/**
	 * Add action
	 *
	 * @access public
	 */
	public function add($owner_model = false, $owner_id = false) {
		$this->setAction('edit', null, $owner_model, $owner_id);
	}
	
	public function edit($id = null, $owner_model = false, $owner_id = false) 
	{
		// Second pass
		if (!empty($this->data['Label'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Label->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			// Try to save
			if ($this->Label->save($this->data)) {
				$this->message('success');
				if ($this->RequestHandler->isAjax()) {
					$this->redirect(array('action' => 'index', $this->data['Label']['owner_model'], $this->data['Label']['owner_id']));
				}
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['Label'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			} else {
				$this->data['Label']['owner_model'] = $owner_model;
				$this->data['Label']['owner_id'] = $owner_id;
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
		if ($this->RequestHandler->isAjax()) {
			$this->render('ajax/edit', 'ajax');
		}
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$fields = null;
		if (!($this->data = $this->Label->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}
	
	function delete($id = null) {
		$this->Label->id = $id;
		$owner_model = $this->Label->field('owner_model');
		$owner_id = $this->Label->field('owner_id');
		if (!$this->Label->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s was not deleted.', true), __d('labels', 'Label', true)), 'alert');
		} else {
            $this->Session->setFlash(sprintf(__('%s was deleted.', true), __d('labels', 'Label', true)), 'success');
		}
		if ($this->RequestHandler->isAjax()) {
			$this->redirect(array('action' => 'index', $owner_model, $owner_id));
		}
		$this->redirect($this->referer());
	}
	

}
?>
