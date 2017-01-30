<?php
class OwnershipsController extends AccessAppController {

	var $name = 'Ownerships';
	
	public function beforeFilter($value='')
	{
		parent::beforeFilter();
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->Auth->allow('bind', 'unbind', 'rebind');
		}
	}

	function index() {
		
		$this->Ownership->recursive = 0;
		$this->set('ownerships', $this->paginate());
	}

	function add() {
		$this->setAction('edit');
	}

	function edit($id = null) {
		
		if (!empty($this->data)) { // 2nd pass
			if (!$id) { // Create a model
				$this->Ownership->create();
			}
			// Try to save data, if it fails, retry
			if ($this->Ownership->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Changes saved to %s \'%s\'.', true) , __d('access', 'Ownership', true), '--'), 'flash_success');
				$this->xredirect();
			} else {
				$this->Session->setFlash(sprintf(__('The %s data could not be saved. Please, try again.', true), __d('access', 'Ownership', true)), 'flash_validation');
			}
		}

		if(empty($this->data)) { // 1st pass
			if ($id) {
				if (!($this->data = $this->Ownership->read(null, $id))) {
					$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('access', 'Ownership', true)), 'flash_error');
					$this->xredirect(); // forget stored referer and redirect
				}
				$model = $this->data['Ownership']['owner_model'];
				$objectModel = $this->data['Ownership']['object_model'];
				App::import('Model', $objectModel);
				$obj = ClassRegistry::init($objectModel);
				$this->set('owners', $this->Ownership->{$model}->find('list'));
				$this->set('objects', $obj->find('list'));				
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	}

	public function bind()
	{
		$owner = array(
			'model' => $this->params['url']['owm'],
			'id' => $this->params['url']['owid']
		);
		$object = array(
			'model' => $this->params['url']['obm'],
			'id' => $this->params['url']['obid']
		);
		$this->Ownership->bind($owner, $object, $this->params['url']['access']);
		$this->set('url', $this->params['url']['cburl']);
	}
	
	public function unbind()
	{
		$owner = array(
			'model' => $this->params['url']['owm'],
			'id' => $this->params['url']['owid']
		);
		$object = array(
			'model' => $this->params['url']['obm'],
			'id' => $this->params['url']['obid']
		);
		$this->Ownership->unbind($owner, $object);
		$this->set('url', $this->params['url']['cburl']);
		$this->render('bind');
	}
	
	public function rebind()
	{
		$owner = array(
			'model' => $this->params['url']['owm'],
			'id' => $this->params['url']['owid']
		);
		$object = array(
			'model' => $this->params['url']['obm'],
			'id' => $this->params['url']['obid']
		);
		$this->Ownership->rebind($owner, $object, $this->params['url']['access']);
		$this->set('url', $this->params['url']['cburl']);
		$this->render('bind');
	}
}
?>