<?php
App::import('Model', 'School.Section');

class CantineTicketsController extends CantineAppController {

	var $name = 'CantineTickets';
	var $components = array('Filters.SimpleFilters');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->selectionActions = array(
			'selectionDelete' => __d('cantine', 'Delete', true)
		);
	}


	function index() {
		if (is_null($this->SimpleFilters->getFilter('CantineTicket.date'))) {
			$date = date('Y-m-d');
			$this->SimpleFilters->setFilter('CantineTicket.date', $date);
			$this->SimpleFilters->setFilter('CantineTicket.date-alt', date('d-m-Y'));
		}
		$this->paginate['CantineTicket'][0] = 'index';
		$this->set('cantineTickets', $this->paginate());
		$this->passSchoolOptionsToView();
	}

    private function passSchoolOptionsToView()
    {
        $this->set('sections', ClassRegistry::init('Section')->find('list'));
        $this->set('levels', ClassRegistry::init('Section')->Level->find('list'));
        $this->set('cycles', ClassRegistry::init('Section')->Cycle->find('list'));
    }

/**
 * By means of Duplicable Behavior, duplicates a Model record and reset some values. Then transfer to edit action.
 *
 * @param string $id
 *
*@return void
 */
	public function duplicate($id) {
		$newID = $this->CantineTicket->duplicate($id);
		if (!$newID) {
			$this->redirect($this->referer());
		}
		$this->CantineTicket->id = $newID;
		$this->redirect(array('action' => 'edit', $newID));
    }
	
	function add() {
		$this->setAction('edit');
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			$create = false;
			if (!$id) {
				$this->CantineTicket->create(); // 2nd pass
				$create = true;
			}
			// Try to save data, if it fails, retry
			if ($this->saveDatesProvided()) {
				$this->saveStudentData();
				$this->message('success');
				// Redirect if we are editing an existing record
				if (empty($create)) {
					$this->setFiltersAndRedirect();
				}
				// New record, force load student data
				$this->refreshModel($id);
			} else {
                $this->Session->setFlash(
                    sprintf(__('The %s could not be saved. Please, try again.', true), 'cantine regular'),
                    'warning');
			}
		}
		if (empty($this->data['CantineTicket'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			} else {
				// Set the DATE value by default to the current calendar day for new records
				$this->data['CantineTicket']['date'] = date('Y-m-d');
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}
	
	private function saveDatesProvided()
	{
		$dates = explode(',', $this->data['CantineTicket']['date']);
		$success = true;
		foreach ((array)$dates as $date) {
			$this->CantineTicket->create();
			$this->data['CantineTicket']['date'] = date('Y-m-d', strtotime($date));
			if(!$this->CantineTicket->save($this->data)) {
				$success = false;
			}
		}
		return $success;
	}
	
	private function saveStudentData()
	{
		if (empty($this->data['Student'])) {
			return false;
		}
		if (empty($this->data['Student']['id'])) {
			$this->data['Student']['id'] = $this->data['CantineTicket']['student_id'];
		}
		$this->CantineTicket->Student->save($this->data);
	}
	
	private function setFiltersAndRedirect()
	{
		$this->SimpleFilters->setUrl(array('action' => 'index'));
		$this->SimpleFilters->setFilter('Student.fullname', $this->data['Student']['fullname']);
		$this->SimpleFilters->setFilter('CantineTicket.date', false);
		$this->SimpleFilters->setFilter('Student.section_id', false);
		$this->SimpleFilters->setFilter('Section.cycle_id', false);
		$this->SimpleFilters->setFilter('Section.level_id', false);
		$this->xredirect();
	}

    protected function refreshModel($id)
    {
        $this->preserveAppData();
        $this->CantineTicket->contain('Student.Section');
        if (!($this->data = $this->CantineTicket->read(null, $id))) {
            $this->message('error');
            $this->xredirect(); // forget stored referer and redirect
        }
        $this->restoreAppData();
	}
	
	protected function _selectionDelete($ids) {
		$this->CantineTicket->deleteAll(array('CantineTicket.id' => $ids));
        $this->Session->setFlash(
            sprintf(__('Selected %s deleted', true), __d('cantine', 'CantineTicket', true)),
            'success');
	}	
	

}
?>
