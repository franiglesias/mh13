<?php
class FeedsController extends AggregatorAppController {

	var $name = 'Feeds';
	var $layout = 'backend';
	var $components = array('Filters.SimpleFilters');
	
/**
 * Allows public actions
 *
 * @return void
 */
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('suggest', 'dashboard'));
	}
	
/**
 * Index for manage feeds
 *
 * @param string $waiting 
 * @return void
 */
	function index($waiting = false) {
		$this->Feed->recursive = 0;
		if ($waiting == 'waiting') {
			$this->paginate['conditions'] = array('approved' => 0);
		}
		$this->set('planets', $this->Feed->Planet->find('list'));
		$this->set('feeds', $this->paginate());
		$this->set(compact('waiting'));
	}
	
	
	function dashboard() {
		if (empty($this->params['requested'])) {
			$this->redirect('/');
		}
		if (!$this->Access->isAuthorizedToken('/aggregator/feeds/index')) {
			return 'disable';
		}
		$this->Feed->recursive = 0;
		$this->set('planets', $this->Feed->Planet->find('list'));
		return $this->Feed->find('all', array('conditions' => array('approved' => 0)));
	}


/**
 * Adds new feeds from the admin backend. We start with a URL feed and try to load
 * it.
 *
 * @return void
 */
	function add() {
		if (!empty($this->data)) {
			$this->Feed->create();
			$this->data['Feed']['approved'] = 1;
			if ($this->Feed->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Changes saved to %s \'%s\'.', true), __d('aggregator', 'Feed', true), $this->data['Feed']['url']), 'flash_success');
				$this->xredirect();
			} else {
				$this->Session->setFlash(sprintf(__('The %s data could not be saved. Please, try again.', true), __d('aggregator', 'Feed', true)), 'flash_validation');
			}
		} else {
			$this->saveReferer();
		}
		$this->set('planets', $this->Feed->Planet->find('list'));
	}

/**
 * Similar to add. Allows visitors to suggest their own feeds. Holds the feeds until
 * is approved by an admin.
 *
 * @param string $planet_id 
 * @return void
 */
	function suggest($planet_id = null) {
		$this->layout = 'basic';
		if (!empty($this->data)) {
			$this->Feed->create();
			if ($this->Feed->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Changes saved to %s \'%s\'.', true), __d('aggregator', 'Feed', true), $this->data['Feed']['feed']), 'flash_success');
				$this->set('returnTo',  $this->data['App']['returnTo']);
				
				$this->render('thanks');
			} else {
				$this->Session->setFlash(sprintf(__('The %s data could not be saved. Please, try again.', true), __d('aggregator', 'Feed', true)), 'flash_validation');
			}
		} else {
			$this->saveReferer();
		}
		
		$this->set('planets', $this->Feed->Planet->find('list', array('conditions' => array('private' => false))));
		$this->set(compact('planet_id'));
	}
	
/**
 * Edit the Feed record
 *
 * @param string $id 
 * @return void
 */
	function edit($id = null) {
		
		if (!empty($this->data)) { // 2nd pass
			if (!$id) { // Create a model
				$this->Feed->create();
			}
			// Try to save data, if it fails, retry
			if ($this->Feed->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Changes saved to %s \'%s\'.', true), __d('aggregator', 'Feed', true), $this->data['Feed']['title']), 'flash_success');
				$this->xredirect();
			} else {
				$this->Session->setFlash(sprintf(__('The %s data could not be saved. Please, try again.', true), __d('aggregator', 'Feed', true)), 'flash_validation');
			}
		}

		if(empty($this->data)) { // 1st pass
			if ($id) {
				if (!($this->data = $this->Feed->read(null, $id))) {
					$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('aggregator', 'Feed', true)), 'flash_error');
					$this->xredirect(); // forget stored referer and redirect
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		
		$this->set('planets', $this->Feed->Planet->find('list'));
		
	}


/**
 * Delete a feed and related entries
 *
 * @param string $id 
 * @return void
 */
	function delete($id = null) {
		if (!$this->Feed->delete($id, true)) {
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('aggregator', 'Feed', true)), 'flash_error');
			$this->redirect($this->referer());
		}
		
		$this->Session->setFlash(sprintf(__('%s was deleted.', true), __d('aggregator', 'Feed', true)), 'flash_success');
		$this->redirect($this->referer());
	}

/**
 * Approves a feed
 *
 * @param string $id 
 * @return void
 */	
	public function approve($id = null) {
		if (!$this->Feed->approve($id)) {
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('aggregator', 'Feed', true)), 'flash_error');
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(sprintf(__d('aggregator', 'Feed %s was approved.', true), $this->Feed->field('title')), 'flash_success');
		$this->redirect($this->referer());
	}

/**
 * Refreshes the entries of a feed
 *
 * @param string $id 
 * @return void
 */
	public function refresh($id = null) {
		if (!$this->Feed->reload($id)) {
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('aggregator', 'Feed', true)));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(sprintf(__d('aggregator', 'Feed %s was refreshed.', true), $this->Feed->field('title')), 'flash_success');
		$this->redirect($this->referer());
	}
	
}
?>