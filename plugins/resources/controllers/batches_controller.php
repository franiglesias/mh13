<?php
class BatchesController extends ResourcesAppController {

	var $name = 'Batches';

	var $components = array('Filters.SimpleFilters');
	var $helpers = array('Uploads.Upload');
	
	var $layout = 'backend';

	function index() {
		
		$this->Batch->recursive = 0;
		$this->set('batches', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {

            $this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('resources', 'batch', true)), 'alert');
			$this->redirect(array('action' => 'index'));
 
		}
		$this->set('batch', $this->Batch->read(null, $id));
	}

	function add() {
		$this->Batch->create();
		$data = array(
			'Batch' => array(
				'title' => __d('resources', 'New batch', true),
				'user_id' => $this->Auth->user('id')
			)
		);
		$this->Batch->save($data);
		$this->setAction('edit', $this->Batch->id);
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->Batch->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			if ($this->Batch->save($this->data)) {
                $this->Session->setFlash(
                    sprintf(__('The %s has been saved.', true), __d('resources', 'batch', true)),
                    'success'
                );
				$url = array(
					'plugin' => 'resources',
					'controller' => 'resources',
					'action' => 'index'
				);
				$this->SimpleFilters->setUrl($url);
				$this->SimpleFilters->setFilter('Resource.batch_id', $id);
				$this->redirect($url);
				// $this->xredirect();
			} else {
                $this->Session->setFlash(
                    sprintf(__('The %s could not be saved. Please, try again.', true), __d('resources', 'batch', true)),
                    'warning'
                );
			}
		}
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Batch->read($fields, $id))) {
                    $this->Session->setFlash(
                        sprintf(__('Invalid %s.', true), __d('resources', 'batch', true)),
                        'alert'
                    );
					$this->xredirect();
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		$users = $this->Batch->User->find('list');
		$levels = $this->Batch->Level->find('list');
		$subjects = $this->Batch->Subject->find('list');
		$this->set(compact('users', 'levels', 'subjects'));
	}

}
?>