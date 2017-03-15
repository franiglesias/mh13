<?php
class CantineIncidencesController extends CantineAppController {

	var $name = 'CantineIncidences';
	var $components = array('Filters.SimpleFilters');
	
	
	function index() {
		$this->paginate['CantineIncidence'][0] = 'index';
		$this->set('cantineIncidences', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}

    public function edit($id = null)
	{
		// Second pass
		if (!empty($this->data['CantineIncidence'])) {
			// Create model if there is no id (add action)
			$create = false;
			if (!$id) {
				$this->CantineIncidence->create();
				$create = true;
			}
			// Data massaging if it is not doable in create or beforeSave

			// Try to save
			if ($this->saveDatesProvided()) {
				$this->saveStudentData();
				$this->message('success');
				if (!$create) {
					$this->xredirect();
				}
				// Force reload
				$this->refreshModel($id);
			} else {
				$this->message('validation');
			}
		}

		// First pass or reload
		if(empty($this->data['CantineIncidence'])) { // 1st pass
			if ($id) {
				$this->refreshModel($id);
			} else {
				// Set the date value by default
				$this->data['CantineIncidence']['date'] = date('Y-m-d');
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// Render preparation
		// Create lists for options, etc.
	}

    private function saveDatesProvided()
    {
        $dates = explode(',', $this->data['CantineIncidence']['date']);
        $success = true;
        foreach ((array)$dates as $date) {
            $this->CantineIncidence->create();
            $this->data['CantineIncidence']['date'] = date('Y-m-d', strtotime($date));
            if (!$this->CantineIncidence->save($this->data)) {
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
            $this->data['Student']['id'] = $this->data['CantineIncidence']['student_id'];
        }
        $this->CantineIncidence->Student->save($this->data);
    }

	protected function refreshModel($id)
	{
		$this->preserveAppData();
		// Data needed to load or reload model
		$fields = null;
		$this->CantineIncidence->contain('Student.Section');
		if (!($this->data = $this->CantineIncidence->read($fields, $id))) {
			$this->message('error');
			$this->xredirect(); // forget stored referer and redirect
		}
		$this->restoreAppData();
	}

	function xedit($id = null) {

		if (!empty($this->data)) {
			if (!$id) {
				$this->CantineIncidence->create(); // 2nd pass
				$this->create = true;
			}
			$dates = explode(',', $this->data['CantineIncidence']['date']);
			$success = true;
			foreach ((array)$dates as $date) {
				$this->CantineIncidence->create();
				$this->data['CantineIncidence']['date'] = date('Y-m-d', strtotime($date));
				if(!$this->CantineIncidence->save($this->data)) {
					$success = false;
				}
			}
			
			if ($success) {
				// Save Student data
				if (!empty($this->data['Student'])) {
					if (empty($this->data['Student']['id'])) {
						$this->data['Student']['id'] = $this->data['CantineIncidence']['student_id'];
					}
					$this->CantineIncidence->Student->save($this->data);
				}
                $this->Session->setFlash(sprintf(__('The %s has been saved.', true), 'cantine incidence'), 'success');
				// Redirect if we are editing an existing record
				if (empty($this->create)) {
					$this->xredirect();
				}
				// New record, force load student data
				$id = $this->CantineIncidence->id;
				// Preserve returnTo data
				$returnTo = $this->data['App']['returnTo'];
				unset($this->data['CantineIncidence']);
			} else {
                $this->Session->setFlash(
                    sprintf(__('The %s could not be saved. Please, try again.', true), 'cantine regular'),
                    'warning'
                );
			}
		}
		if (empty($this->data['CantineIncidence'])) { // 1st pass
			if ($id) {
				$fields = null;
				$this->CantineIncidence->contain('Student.Section');
				if (!($this->data = $this->CantineIncidence->read($fields, $id))) {
                    $this->Session->setFlash(sprintf(__('Invalid %s.', true), 'cantine incidence'), 'alert');
					$this->xredirect();
				}
			} else {
				// Set the date value by default
				$this->data['CantineIncidence']['date'] = date('Y-m-d');
			}
			// Manage referers
			if (!empty($returnTo)) {
				$this->data['App']['returnTo'] = $returnTo;
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		// $this->_setCommonOptions();
		
	}

}
?>