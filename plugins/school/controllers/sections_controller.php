<?php
class SectionsController extends SchoolAppController {

	var $name = 'Sections';
	var $layout = 'backend';
	var $components = array('Filters.SimpleFilters');
	var $helpers = array('School.Students');

	function index() {
		
		$this->Section->recursive = 0;
		$this->_setCommonOptions();
		$this->set('sections', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}

	public function edit($id = null) 
	{
		// Second pass
		if (!empty($this->data['Section'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this->Section->create();
			}
			// Data massaging if it is not doable in create or beforeSave
			
			// Try to save
			if ($this->Section->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}
		
		// First pass or reload
		if(empty($this->data['Section'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
		$this->_setCommonOptions();
		$this->set('tutors', $this->Section->findTutors(true));
		$this->set('students', $this->Section->Student->find('section', $id));
		
	}

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$fields = null;
		if (!($this->data = $this->Section->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

	protected function _setCommonOptions()
	{
		$this->set('cantineGroups', $this->Section->CantineGroup->find('list')); 
		$this->set('levels', $this->Section->Level->find('list'));
		$this->set('cycles', $this->Section->Cycle->find('list'));
		$this->set('stages', $this->Section->Stage->find('list'));
		$this->set('tutors', $this->Section->findTutors());
	}

}
?>