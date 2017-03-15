<?php
class PositionsController extends ResumesAppController {

	var $name = 'Positions';
	var $layout = 'backend';

	function index() {
		
		$this->Position->recursive = 0;
		$this->set('positions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {

            $this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('resumes', 'position', true)), 'alert');
			$this->redirect(array('action' => 'index'));
 
		}
		$this->set('position', $this->Position->read(null, $id));
	}

	function add() {
		$this->setAction('edit');
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->Position->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			if ($this->Position->save($this->data)) {

                $this->Session->setFlash(
                    sprintf(__('The %s has been saved.', true), __d('resumes', 'position', true)),
                    'success'
                );
				$this->xredirect();
 
			} else {

                $this->Session->setFlash(
                    sprintf(
                        __('The %s could not be saved. Please, try again.', true),
                        __d('resumes', 'position', true)
                    ),
                    'warning'
                );
 
			}
		}
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Position->read($fields, $id))) {

                    $this->Session->setFlash(
                        sprintf(__('Invalid %s.', true), __d('resumes', 'position', true)),
                        'alert'
                    );
					$this->xredirect();
					 
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}

}
?>