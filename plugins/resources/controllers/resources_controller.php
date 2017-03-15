<?php
class ResourcesController extends ResourcesAppController {

	var $name = 'Resources';
	
	var $layout = 'backend';
	var $components = array('Filters.SimpleFilters');
	var $helpers = array('Ui.Media');

	function index() {
		
		if ($this->Access->isAuthorizedToken('//resources/administrator')) {
			$this->set('canAdmin', true);
		} else {
			$this->SimpleFilters->setFilterIfNull('Resource.user_id', $this->Auth->user('id'));
		}
		$this->paginate['Resource'][0] = 'index';
		if ($tags = $this->SimpleFilters->getFilter('Tagged.by')) {
			$this->paginate['Resource']['tags'] = $tags;
			$this->paginate['Resource'][0] = 'filter';
		}
		$this->set('resources', $this->paginate());
		$this->set('user_id', $this->Auth->user('id'));
		$this->_setLists();
	}

    public function _setLists()
    {
        $users = $this->Resource->User->find('list', array('fields' => array('id', 'realname')));
        $users[$this->Auth->user('id')] .= __(' (Me)', true);
        $batches = $this->Resource->Batch->find('list');
        $levels = $this->Resource->Level->find('list');
        $subjects = $this->Resource->Subject->find('list');
        $this->set(compact('users', 'batches', 'levels', 'subjects'));
    }

	public function search($new = false) {
		if (!empty($new)) {
			$this->Session->delete('Search.Resources');
		}
		$this->_setLists();
		if (!$this->data) {
			$term = $this->Session->read('Search.Resources.term');
			$subject_id = $this->Session->read('Search.Resources.subject_id');
			$level_id = $this->Session->read('Search.Resources.level_id');

			if (!$term && !$subject_id && !$level_id) {
				$this->render('search');
				return;
			}

			if ($level_id) {
				$this->paginate['Resource']['conditions']['Resource.level_id'] = $level_id;
			}
			if ($subject_id) {
				$this->paginate['Resource']['conditions']['Resource.subject_id'] = $subject_id;
			}

		} else {
			$term = $this->data['Sindex']['term'];
			if (!empty($this->data['Resource']['level_id'])) {
				$this->paginate['Resource']['conditions']['Resource.level_id'] = $this->data['Resource']['level_id'];
			}
			if (!empty($this->data['Resource']['subject_id'])) {
				$this->paginate['Resource']['conditions']['Resource.subject_id'] = $this->data['Resource']['subject_id'];
			}

			$this->Session->write('Search.Resources.term', $term);
			$this->Session->write('Search.Resources.subject_id', $this->data['Resource']['subject_id']);
			$this->Session->write('Search.Resources.level_id', $this->data['Resource']['level_id']);
		}
		if (!empty($term)) {
			$this->paginate['Resource']['0'] = 'search';
			$this->paginate['Resource']['term'] = $term;
			// $this->paginate['Resource']['fields'] = array('File.path', 'File.id');
			$this->paginate['Resource']['contain'] = array(
				'Batch',
				'Version' => array(
					'Upload' => array('fields' => array('id', 'path')),
					'fields' => array('id', 'version', 'comment'),
					'order' => array('Version.created' => 'desc'),
					'limit' => 1
				)
			);

		} else {
			// Perform a simple find all if no search term
			$this->paginate['Resource'][0] = 'index';
		}
		$resources = $this->paginate('Resource');

		foreach ($resources as $key => $resource) {
			$resources[$key]['Version'] = $resource['Version'][0];
			$resources[$key]['Upload'] = $resources[$key]['Version']['Upload'];
		}

		$this->set(compact('resources', 'term'));
		$this->set('user_id', $this->Auth->user('id'));
		$this->render('index');
	}

/**
 * In this case, view acts as an edit action since you may edit the tags for the resource
 *
 * @param string $id
 *
*@return void
 * @author Fran Iglesias
 */
	function view($id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->Resource->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			if ($this->Resource->save($this->data)) {
                $this->Session->setFlash(
                    sprintf(__('The %s has been saved.', true), __d('resources', 'resource', true)),
                    'success');
				$this->xredirect();
			} else {
                $this->Session->setFlash(
                    sprintf(
                        __('The %s could not be saved. Please, try again.', true),
                        __d('resources', 'resource', true)
                    ),
                    'warning');
			}
		}
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Resource->retrieve($fields, $id))) {
                    $this->Session->setFlash(
                        sprintf(__('Invalid %s.', true), __d('resources', 'resource', true)),
                        'alert');
					$this->xredirect();
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		$this->_setLists();
	}

	function add() {
		$this->setAction('edit');
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->Resource->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			if ($this->Resource->save($this->data)) {
                $this->Session->setFlash(
                    sprintf(__('The %s has been saved.', true), __d('resources', 'resource', true)),
                    'success');
				$this->xredirect();
				unset($this->data['Resource']);
			} else {
                $this->Session->setFlash(
                    sprintf(
                        __('The %s could not be saved. Please, try again.', true),
                        __d('resources', 'resource', true)
                    ),
                    'warning');
			}
		}
		if (empty($this->data['Resource'])) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Resource->retrieve($fields, $id))) {
                    $this->Session->setFlash(
                        sprintf(__('Invalid %s.', true), __d('resources', 'resource', true)),
                        'alert');
					$this->xredirect();
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		$this->_setLists();
    }
	
/**
 * Allows the uploading of a new version of the file
 *
 * @param string $id
 *
*@return void
 * @author Fran Iglesias
 */
	public function upgrade($id = false)
	{
		if (!empty($this->data)) {
			$this->Resource->autoAddVersion($this->data['Resource']['id'], $this->data['Version']['comment']);
			$this->xredirect();
		}
		if (empty($this->data)) {
			if ($id) {
				$fields = '';
			}
			$this->Resource->contain('Version');
			if (!$this->data = $this->Resource->read($fields, $id)) {
                $this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('resources', 'resource', true)), 'alert');
				$this->xredirect();
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}
	
	public function revert($id, $vid)
	{
		$this->Resource->revert($id, $vid);
		$resource = $this->Resource->retrieve(null, $id);
		$this->set(compact('resource'));
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$this->render('ajax/history', 'ajax');
		}
	}
	
	public function history($id)
	{
		$resource = $this->Resource->retrieve(null, $id);
		$this->set(compact('resource'));
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$this->render('ajax/history', 'ajax');
		}

	}
	
	public function current($id)
	{
		$resource = $this->Resource->retrieve(null, $id);
		$this->set(compact('resource'));
		$this->_setLists();
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$this->render('ajax/current', 'ajax');
		}

	}
	
	public function delete_version($vid)
	{
		$this->Resource->Version->id = $vid;
		$id = $this->Resource->Version->field('resource_id');
		$this->Resource->Version->delete($vid);
		$resource = $this->Resource->retrieve(null, $id);
		$this->set(compact('resource'));
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$this->render('ajax/history', 'ajax');
		}
	}
	
}
?>