<?php


class UploadsController extends UploadsAppController {

	var $name = 'Uploads';
	var $helpers = array(
		'Ui.Table', 'Uploads.Upload', 'Ui.Media');
	var $layout = 'backend';
	var $components = array(
		'Filters.SimpleFilters'
		);
	private $FileUploader;
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('up', 'rotate', 'attach', 'inline', 'single', 'attachments', 'download'));
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->Auth->allow(array('index', 'edit', 'delete', 'upload', 'rotate', 'owned'));
		}
	}

	function delete($id = null) {
		$this->Upload->setId($id);
		$foreign_key = $this->Upload->field('foreign_key');
		$model = $this->Upload->field('model');
		if (!$this->Upload->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s was not deleted.', true), __d('uploads', 'Upload', true)), 'flash_alert');
		} else {
			$this->Session->setFlash(sprintf(__('%s was deleted.', true), __d('uploads', 'Upload', true)), 'flash_success');
		}
		if ($this->RequestHandler->isAjax()) {
			$this->redirect(array('action' => 'index', $model, $foreign_key));
		}
		$this->redirect($this->referer());
	}
	
	function edit($id = null) {
		if (!$id && empty($this->data['Upload'])) {
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('uploads', 'Upload', true)), 'flash_error');
			$this->xredirect();
		}
		if (!empty($this->data['Upload'])) {
			if ($this->Upload->save($this->data)) {				
				$this->Session->setFlash(sprintf(__('Changes saved to %s \'%s\'.', true), __d('uploads', 'Upload', true), $this->data['Upload']['name']), 'flash_success');
				if ($this->RequestHandler->isAjax()) {
					$this->redirect(array('action' => 'index', $this->data['Upload']['model'], $this->data['Upload']['foreign_key'], 'page' => $this->params['named']['page']));
				}

				$this->xredirect();
			} else {
				$this->Session->setFlash(sprintf(__('The %s data could not be saved. Please, try again.', true), __d('uploads', 'Upload', true)), 'flash_validation');
			}
		}
		if(empty($this->data['Upload'])) {
			$this->data = $this->Upload->read(null, $id);

			if (empty($this->data['Upload'])) {
				$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('uploads', 'Upload', true)), 'flash_error');
				$this->redirect(array('action' => 'index'));
			}
			$this->saveReferer();
		}
		if ($this->RequestHandler->isAjax()) {
			$this->render('ajax/edit', 'ajax');
		}

		$related = $this->Upload->relatedFiles($id);
		$this->set(compact('related'));
	}
	
	public function index($model = false, $fk = false) {
		$this->paginate['Upload'][0] = 'checked';
		$this->filterByModelFK($model, $fk);
		$this->set('uploads', $this->paginate('Upload'));
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/index', 'ajax');
		}
	}

	public function owned($model = false, $fk = false)
	{
		$this->paginate['Upload'][0] = 'checked';
		if (!empty($model) && !empty($fk)) {
			$this->filterByModelFK($model, $fk);
			$this->set('uploads', $this->paginate('Upload'));
		} else {
			$this->set('uploads', false);
		}
		if ($this->RequestHandler->isAjax() || !empty($this->params['requested'])) {
			$this->render('ajax/index', 'ajax');
		}
	}
	
	private function filterByModelFK($model, $fk)
	{
		if (empty($model) || empty($fk)) {
			return;
		}
		$this->paginate['Upload']['conditions'] = array(
			'Upload.model' => $model,
			'Upload.foreign_key' => $fk
		);
		$this->paginate['Upload']['limit'] = Configure::read('Theme.limits.page');
		$this->paginate['Upload']['order'] = array('Upload.order' => 'asc');
	}
	

/**
 * Retrieve files related to a model
 *
 * @param string $model Model class name
 * @param string $fk Model foreign key
 */
	public function attachments($model = false, $fk = false)
	{
		$this->layout = 'ajax';
		if (!$model || !$fk) {
			$this->render('nofiles');
			return;
		}
		$conditions = array(
			'Upload.model' => $model,
			'Upload.foreign_key' => $fk
		);
		$order = array(
			'Upload.order' => 'desc'
		);
		
		if ($attachments = $this->Upload->find('all', compact('conditions', 'order'))) {
			$this->set('attachments', $attachments);
		} else {
			$this->render('nofiles');
		}
	}

/**
 * Retrieves a single file given its name. If several, returns the first
 *
 * @param string $file 
 * @return void
 */
	public function single($file = false)
	{
		$this->layout = 'ajax';
		if (!$file) {
			$this->render('nofiles');
			return;
		}
		file_put_contents(LOGS.'mh-uploads.log', date('Y-m-d H:i > ').'[Single] '.$this->computeFileLocation($file).chr(10), FILE_APPEND);
		$this->set('path', $this->computeFileLocation($file));
	}
	
	private function computeFileLocation($file)
	{
		file_put_contents(LOGS.'mh-uploads.log', date('Y-m-d H:i > ').'[computeLocation] '
			.$this->params['url']['class']
				.DS.$this->params['url']['fk']
				.DS.$this->params['url']['field']
				.DS.$file
			
			.chr(10), FILE_APPEND);
		
		return $this->params['url']['class']
				.DS.$this->params['url']['fk']
				.DS.$this->params['url']['field']
				.DS.$file;
		
	}
	
	public function rotate() {
		$file = $this->params['url']['file'];
		$angle = $this->params['url']['angle'];
		$size = $this->params['url']['size'];
		// extract($this->params['url']);
		$imageFile = $this->Upload->find('first',
			array(
				'fields' => array('id', 'fullpath'),
				'conditions' => array('path' => $file)
				)
		);
		$imagePath = $imageFile['Upload']['fullpath'];
		App::import('Lib', 'FiImage');
		$FiImage = new FiImage();
		$FiImage->rotate($imagePath, $angle);
		$this->Upload->refresh($imageFile['Upload']['id']);
		$this->set(array(
			'image' => $file,
			'size' => $size
		));
	}

/**
 * Forces the download of a file given the Upload.id or its name
 *
 * @param string $id 
 * @return void
 */	
	function download($id = null) {
		if (preg_match('/^[0-9a-f]{8,8}-[0-9a-f]{4,4}-[0-9a-f]{4,4}-[0-9a-f]{4,4}-[0-9a-f]{12,12}$/', $id)) {
			$result = $this->Upload->find('first', array('conditions' => array('id' => $id)));
		
			if (!$result) {
				$this->Session->setFlash(__('Invalid Upload', true), 'flash_error');
				$this->redirect(array('action' => 'index'));
			}
			list($name, $extension) = explode('.', basename($result['Upload']['path']));
			$path = dirname($result['Upload']['fullpath']).DS;
			$file = basename($result['Upload']['fullpath']);
			$type = $result['Upload']['type'];
			
		} else {
			$file = $id; 
			$path = Configure::read('Uploads.private');
			list($name, $extension) = explode('.', $id);
			$id3 = new FiId3($path);
			$info = $id3->info();
			unset($id3);
			$type = $info['type'];
		}
		
		$this->view = 'Media';

        $params = array(
			'id' => $file,
			'name' => $name,
			'download' => true,
			'extension' => strtolower($extension),
			'mimeType' => array(strtolower($extension) => $type),
			'path' => $path,
       );
       $this->set($params);
	}
	

	
/**
 * Backend for file uploading
 *
 * @return void
 */
	public function upload() {
		App::import('Lib', 'Uploads.file_receiver/FileReceiver');
		App::import('Lib', 'Uploads.file_dispatcher/FileDispatcher');
		App::import('Lib', 'Uploads.file_binder/FileBinder');
		App::import('Lib', 'Uploads.UploadedFile');
		
		$this->cleanParams();
		$Receiver = new FileReceiver($this->params['url']['extensions'], $this->params['url']['limit']);
		$Dispatcher = new FileDispatcher(
			Configure::read('Uploads.base'),
			Configure::read('Uploads.private')
			);
		$Binder = new FileBinder($Dispatcher, $this->params['url']);
		try {
			$File = $Receiver->save(Configure::read('Uploads.tmp'));
			$Binder->bind($File);
			$this->set('response', $File->getResponse());
			file_put_contents(LOGS.'mh-uploads.log', date('Y-m-d H:i > ').'Uploaded '.$File->getName().chr(10), FILE_APPEND);
		} catch (RuntimeException $e) {
			file_put_contents(LOGS.'mh-uploads.log', date('Y-m-d H:i > ').$e->getMessage().chr(10), FILE_APPEND);
			$this->set('response', $this->failedResponse($e));
		}
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('js');
	}
	
	private function cleanParams()
	{
		if (empty($this->params['url']['limit'])) {
			$this->params['url']['limit'] = 300 * 1024 * 1024;
		}
		foreach ($this->params['url'] as $key => $value) {
			if ($value == 'undefined') {
				$this->params['url'][$key] = null;
			}
		}
		if (!empty($this->params['url']['extensions'])) {
			$this->params['url']['extensions'] = explode(',', $this->params['url']['extensions']);
		} else {
			$this->params['url']['extensions'] = false;
		}
	}
	
	private function failedResponse(Exception $e)
	{
		return array(
			'success' => false,
			'error' => $e->getMessage(),
			'file' => false,
			'path' => false,
			'fullPath' => false
		);
	}
	
}
?>