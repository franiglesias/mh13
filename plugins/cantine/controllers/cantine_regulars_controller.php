<?php

App::import('Model', 'School.Section');

class CantineRegularsController extends CantineAppController {

	var $name = 'CantineRegulars';
	var $components = array('Filters.SimpleFilters');
	var $helpers = array('Ui.Csv');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->selectionActions = array(
			'selectionDelete' => __d('cantine', 'Delete', true)
		);
		$this->defaultFilter = array(
			'CantineRegular.month' => date('m')
		);
	}

	function index() {
		$this->paginate['CantineRegular'][0] = 'index';
		if ($this->reportRequested()) {
			$this->set('cantineRegulars', $this->CantineRegular->find('index', $this->paginate['CantineRegular']));
		} else {
			$this->set('cantineRegulars', $this->paginate());
		}
		if ($this->csvRequested()) {
			$this->prepareCSV();
		}
		$this->passMonthsToView();
		$this->passSchoolOptionsToView();
	}
	
	private function reportRequested()
	{
		if (empty($this->params['named']['report'])) {
			$this->set('report', false);
			return false;
		}
		$this->set('report', true);
		return true;
	}

    private function csvRequested()
    {
        return ($this->params['url']['ext'] == 'csv');
    }

    private function prepareCSV()
    {
        $this->set('fileName', 'Invoicing.csv');
        $this->autoLayout = false;
        Configure::write('debug', 0);
    }

    private function passMonthsToView()
    {
        $this->set(
            'months',
            array(
                9 => __('september', true),
                10 => __('october', true),
                11 => __('november', true),
                12 => __('december', true),
                1 => __('january', true),
                2 => __('february', true),
                3 => __('march', true),
                4 => __('april', true),
                5 => __('may', true),
                6 => __('june', true),
            )
        );
    }

    private function passSchoolOptionsToView()
    {
        $this->passSectionsToView();
        $this->set('levels', ClassRegistry::init('Section')->Level->find('list'));
        $this->set('cycles', ClassRegistry::init('Section')->Cycle->find('list'));
    }

    private function passSectionsToView()
    {
        $this->set('sections', ClassRegistry::init('Section')->find('list'));
    }

    // We set this filter so the application will provide full feedback to the user

	function add() {
		$this->CantineRegular->create();
		$this->CantineRegular->save(null, false);
		$this->setAction('edit', $this->CantineRegular->getID());
	}

    function edit($id = null)
    {
        if (!empty($this->data)) {
            $create = false;
            if (!$id) {
                $this->CantineRegular->create(); // 2nd pass
                $create = true;
            }
            if ($this->saveDatesProvided()) {
                $this->saveStudentData();
                $this->message('success');
                // Redirect if we are editing an existing record
                if (!$create) {
                    $this->setFiltersAndRedirect();
                }
                // New record, force load student data
                $this->refreshModel($id);
            } else {
                $this->message('validation');
                $this->packDaysOfWeek();
            }
        }
        if (empty($this->data['CantineRegular'])) { // 1st pass
            if ($id) {
                $this->refreshModel($id);
            } else {
                // Set the month value by default to the next calendar month for new records
                $this->data['CantineRegular']['month'] = $this->defaultMonth();
            }
            $this->saveReferer(); // Store actual referer to use in 2nd pass
        }
        $this->passMonthsToView();
        $this->passSectionsToView();
    }
	
	private function saveDatesProvided()
	{
		$success = true;
		$months = $this->data['CantineRegular']['month'];
		foreach ((array)$months as $month) {
			$this->CantineRegular->create();
			$this->data['CantineRegular']['month'] = $month;
			if(!$this->CantineRegular->save($this->data)) {
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
			$this->data['Student']['id'] = $this->data['CantineRegular']['student_id'];
		}
		$this->CantineRegular->Student->save($this->data);
	}

	public function setFiltersAndRedirect()
	{
		$this->SimpleFilters->setUrl(array('action' => 'index'));
		$this->SimpleFilters->setFilter('Student.fullname', $this->data['Student']['fullname']);
		$this->SimpleFilters->setFilter('CantineRegular.month', false);
		$this->SimpleFilters->setFilter('Student.section_id', false);
		$this->SimpleFilters->setFilter('Section.cycle_id', false);
		$this->SimpleFilters->setFilter('Section.level_id', false);
		$this->xredirect();
	}

    protected function refreshModel($id)
	{
		$this->preserveAppData();
		$this->CantineRegular->contain('Student.Section');
		if (!($this->data = $this->CantineRegular->read(null, $id))) {
			$this->message('error');
			$this->xredirect();
		}
		$this->restoreAppData();
	}
	
	private function packDaysOfWeek()
	{
		if (is_array($this->data['CantineRegular']['days_of_week'])) {
			$this->data['CantineRegular']['days_of_week'] = array_sum($this->data['CantineRegular']['days_of_week']);
		}

	}
	
	private function defaultMonth()
	{
		$month = date('m') + 1;
		return $month > 12 ? 1 : $month;
	}
	
/**
 * By means of Duplicable Behavior, duplicates a Model record and reset some values. Then transfer to edit action.
 *
 * @param string $id
 *
*@return void
 */
	public function duplicate($id) {
		$newID = $this->CantineRegular->duplicate($id);
		if (!$newID) {
			$this->redirect($this->referer());
		}
		$this->CantineRegular->id = $newID;
		$this->redirect(array('action' => 'edit', $newID));
	}
	
	public function next($month = false) {
		if (!($month = $this->SimpleFilters->getFilter('CantineRegular.month'))) {
			$month = date('m');
		}
		$this->CantineRegular->copyToNewMonth($month);
		$this->redirect(array('action' => 'index'));
	}
	
	protected function _selectionDelete($ids) {
		$this->CantineRegular->deleteAll(array('CantineRegular.id' => $ids));
        $this->Session->setFlash(
            sprintf(__('Selected %s deleted', true), __d('cantine', 'CantineRegular', true)),
            'success');
	}	
	
	
}
?>