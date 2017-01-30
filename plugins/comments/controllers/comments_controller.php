<?php
class CommentsController extends CommentsAppController {

	var $name = 'Comments';
	var $layout = 'backend';
	var $components = array('Filters.SimpleFilters');
	var $helpers = array('Comments.Comment');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array('comment', 'display'));
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->Auth->allow(array('index', 'rotate', 'comment', 'display'));
		}
	}

	function index($modelClass = false, $id = false) {
		if (!empty($modelClass)) {
			App::import('Model', $modelClass);
			list($plugin, $class) = explode('.', $modelClass);
			if (!$class) {
				$class = $plugin;
				$plugin = false;
			}
			$Model = ClassRegistry::init($class);
			if (method_exists($Model, 'commentsQuery')) {
				$query = $Model->commentsQuery($id);
				$this->paginate['Comment'] = $query;
			} else {
				$this->paginate['Comment']['conditions'] = array(
					'Comment.object_model' => $modelClass,
					'Comment.object_fk' => $id
				);
			}
			$this->paginate['Comment']['order'] = array('Comment.created' => 'desc');
			$this->paginate['Comment']['limit'] = WIDGET_PAGE_LIMIT;
		}
		
		$this->set('comments', $this->paginate('Comment'));
		$this->set('states', $this->Comment->states);
		
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/index', 'ajax');
		}
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->Comment->create();
			}

			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved.', true), __d('comments', 'comment', true)), 'flash_success');
				$this->xredirect();
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __d('comments', 'comment', true)), 'flash_validation');
			}
		}
		if (empty($this->data)) {
			if ($id) {
				if (!($this->data = $this->Comment->read(null, $id))) {
					$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('comments', 'comment', true)), 'flash_error');
					$this->redirect(array('action' => 'index'));
				}
			}
			$this->saveReferer();
		}
		$this->set('states', $this->Comment->states);
	}

	function delete($id = null) {
		if (!$this->Comment->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s was not deleted.', true), __d('comments', 'comment', true)), 'flash_alert');
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(sprintf(__('%s was deleted.', true), __d('comments', 'comment', true)), 'flash_success');
		$this->redirect($this->referer());
	}
	
	public function display($model, $id)
	{
		if (empty($this->params['requested'])) {
			$mode = $this->Comment->mode($model, $id);
		}

		$commentsList = $this->Comment->find('all',array(
			'conditions' => array(
				'Comment.object_model' => $model, 
				'Comment.object_fk' => $id, 
				'Comment.approved' => 2),
			'order' => array('Comment.created' => 'asc')
			)
		);
		
		$this->set(compact('mode'));
		$this->set(compact('commentsList'));
		return $commentsList;
	}
	
	public function form($model, $id) {
		$user = $this->Auth->user();

		$this->set(compact('user', 'model', 'id'));
	}
		
	public function comment()
	{
		if (empty($this->data)) {
			return;
		}
		$mode = $this->Comment->mode($this->data['Comment']['object_model'], $this->data['Comment']['object_fk']);
		$this->set(compact('mode'));
		if ($mode == COMMENTS_FREE) {
			$this->data['Comment']['approved'] = 2;
		}
		$success = false;
		if ($this->Comment->antispam($this->data, $this->Session->read('Turing'))) {
			$this->Comment->create();
			$success = $this->Comment->save($this->data);
		}
		$this->Session->delete('Turing');
			
		if ($this->RequestHandler->isAjax()) {
			if ($success) {
				$this->data['Comment']['comment'] = '';
				if ($mode < COMMENTS_FREE) {
					$message =  __d('comments', 'Comment waiting for approving.', true);
				} else {
					$message =  __d('comments', 'Accepted Comment.', true);
				}
			} else {
				$message =  __d('comments', 'Invalid or Spam Comment.', true);
			}
			$this->set('model', $this->data['Comment']['object_model']);
			$this->set('fk', $this->data['Comment']['object_fk']);
			$this->set(compact('message'));
			$this->render('comment');
		} else {
			if ($success) {
				$this->Session->setFlash(sprintf(__('The %s has been saved.', true), __d('comments', 'comment', true)), 'flash_success');
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __d('comments', 'comment', true)), 'flash_validation');
			}
			$this->redirect(unserialize($this->data['Comment']['redirect']));
		}
	}
	
	public function purgue() {
		$this->Comment->purgue();
		$this->redirect($this->referer());
	}
	
	public function rotate($id)
	{
		if (!$this->RequestHandler->isAjax()) {
			$this->redirect('/');
		}
		list($field, $id) = explode('_', $id);
		$this->Comment->rotateField('approved', 3, $id);
		$this->Comment->id = $id;
		$this->set('value', $this->Comment->field('approved'));
		$this->set('values', $this->Comment->states);
		$this->set('uid', $id);
		$this->render('ajax/rotate');
	}
	

	
}
?>