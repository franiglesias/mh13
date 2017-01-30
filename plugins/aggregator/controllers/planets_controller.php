<?php
class PlanetsController extends AggregatorAppController {

	var $name = 'Planets';
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('all'));
		$this->layout = 'backend';
	}
	

	function index() {
		
		$this->Planet->recursive = 0;
		$this->paginate['Planet']['fields'] = array('id', 'title', 'description', 'private');
		$this->set('planets', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}

	function edit($id = null) {
		if (!empty($this->data)) { // 2nd pass
			if (!$id) { // Create a model
				$this->Planet->create();
			}
			// Try to save data, if it fails, retry
			if ($this->Planet->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Changes saved to %s \'%s\'.', true), __d('aggregator', 'Planet', true), $this->data['Planet']['title']), 'flash_success');
				$this->xredirect();
			} else {
				$this->Session->setFlash(sprintf(__('The %s data could not be saved. Please, try again.', true), __d('aggregator', 'Planet', true)), 'flash_validation');
			}
		}

		if(empty($this->data)) { // 1st pass
			if ($id) {
				if (!($this->data = $this->Planet->read(null, $id))) {
					$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('aggregator', 'Planet', true)), 'flash_error');
					$this->xredirect(); // forget stored referer and redirect
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}



	function delete($id = null) {
		if (!$this->Planet->delete($id)) {
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('aggregator', 'Planet', true)), 'flash_error');
			$this->redirect($this->referer());
		}

		$this->Session->setFlash(sprintf(__('%s was deleted.', true), __d('aggregator', 'Planet', true)), 'flash_success');
		$this->redirect($this->referer());
	}


/**
 * Returns a linked list with all the planets in the site only for element /planets/all
 * via Request Action
 *
 * @return void
 */
	public function all() {
		if (!empty($this->params['requested'])) {
			$planets = $this->Planet->find('all', array('fields' => array('title', 'slug'), 'order' => array('title' => 'ASC')));
			return $planets;
		}
	}
}
?>