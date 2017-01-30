<?php
class MeritsController extends ResumesAppController {

	var $name = 'Merits';
	var $layout = 'resumes';
	var $helpers = array('Resumes.Resume');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
	
	public function show($type = null)
	{
		$resume_id = $this->Session->read('Resume.Auth.id');
		if (!$resume_id) {
			$this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
		}
		$this->paginate['Merit'][0] = 'show';
		$this->paginate['Merit']['merit_type_id'] = $type;
		$this->paginate['Merit']['resume_id'] = $resume_id;
		$merits = $this->paginate('Merit');
		$meritType = $this->Merit->MeritType->find('first', array('conditions' => array('id' => $type)));
		$this->set(compact('merits', 'type', 'meritType'));
	}

	function add($type) {
		$this->Merit->create();
		$this->Merit->set(array(
			'merit_type_id' => $type,
			'resume_id' => $this->Session->read('Resume.Auth.id')
		));
		$this->Merit->save();
		$this->setAction('edit', $this->Merit->getLastInsertID(), $type);
	}

	function edit($id = null, $type = null) {
		$resume_id = $this->Session->read('Resume.Auth.id');
		if (!$resume_id) {
			$this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
		}
		
		if (!empty($this->data)) {
			if (!$id) {
				$this->Merit->create();
			}

			if ($this->Merit->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved.', true), __d('resumes', 'Merit', true)), 'flash_success');
				$this->xredirect();
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __d('resumes', 'Merit', true)), 'flash_validation');
			}
		}
		if (empty($this->data)) {
			if ($id) {
				if (!($this->data = $this->Merit->read(null, $id))) {
					$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('resumes', 'Merit', true)), 'flash_error');
					$this->xredirect();
				}
			} else {
				$this->data['Merit']['merit_type_id'] = $type;
				$this->data['Merit']['resume_id'] = $resume_id;
			}
			$this->saveReferer();
		}
		
		$meritTypes = $this->Merit->MeritType->find('list');
		$meritType = $this->Merit->MeritType->find('first', array('conditions' => array('id' => $this->data['Merit']['merit_type_id'])));
		$resumes = $this->Merit->Resume->find('list', array('fields' => array('id', 'email')));
		$this->set(compact('meritType', 'meritTypes', 'resumes'));
	}

}
?>