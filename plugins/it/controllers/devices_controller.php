<?php
class DevicesController extends ItAppController {

	var $name = 'Devices';
	var $helpers = array('Uploads.Upload', 'Ui.Media', 'It.Device');
	var $components = array(
		'Filters.SimpleFilters'
		);
	
	function index() {
		
		// $status = $this->SimpleFilters->getFilter('Device.status');
		// $this->SimpleFilters->setFilterIfNull('Device.status', 1);
		$this->Device->recursive = 0;
		$this->set('devices', $this->paginate());
		$deviceTypes = $this->Device->DeviceType->find('list');
		$this->set(compact('deviceTypes'));
	}

	function add() {
		$this->setAction('edit');
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->Device->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			if ($this->Device->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				if ($this->params['form']['save_and_work']) {
					$id = $this->data['Device']['id'];
					$this->data = false;
				}
			} else {
				$this->message('validation');
			}
		}
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Device->read($fields, $id))) {
					$this->message('invalid');
					$this->xredirect();
				}
			} else {
				$this->data['Device']['status'] = 0;
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		$deviceTypes = $this->Device->DeviceType->find('list');
		$this->set(compact('deviceTypes'));
		$this->set('statuses', $this->Device->statuses);
	}

	public function retire($id = null) {
		try {
			$this->Device->id = $id;
			$identifier = $this->Device->field('title');
			$this->Device->retire($id);
		} catch	(InvalidArgumentException $e) {
			$this->message('invalid');
			$this->xredirect();
		} catch (Exception $e) {
			$this->cakeError('exception', array('exception' => $e, 'url' => $this->here, 'redirect' => $this->referer()));
		}
		$this->message('success');
		$this->xredirect();
	}

	public function duplicate($id)
	{
		$newID = $this->Device->duplicate($id, array(
			'cascade' => false,
			'callbacks' => true,
			'changeFields' => array('title')
		));
		if (!$newID) {
			$this->redirect($this->referer());
		}
		$this->Device->id = $newID;
		$this->redirect(array('action' => 'edit', $newID));
	}
	
	public function dashboard() {
		// Retrieve device in maintenance with identifier and remarks. Accesible to any user.
		if (empty($this->params['requested'])) {
			$this->redirect('/');
		}
		return $this->Device->find('maintenance');
	}
	
	public function device($id = null)
	{	
		$this->RequestHandler->respondAs('js');
		Configure::write('debug', 0);
		$this->set('device', $this->Device->read(null, $id));
		$this->render('json/device');
	}
}
?>