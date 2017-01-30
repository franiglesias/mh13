<?php
class Upload extends UploadsAppModel {

	var $name = 'Upload';
	
	var $_findMethods = array (
	    'all' => true,
	    'first' => true,
	    'list' => true,
	    'count' => true,
	    'neighbors' => true,
	    'threaded' => true,
		'checked' => true,
		);
		
	var $actsAs = array(
		'Uploads.Upable' => array(
			'file' => array(
				'move' => 'route',
				'return' => 'path'
				)
			)
		);

/**
 * Deletes files when their record is deleted
 *
 * @param boolean $cascade 
 * @return void
 */	
	function beforeDelete($cascade = true) {
		return $this->deleteRelatedFiles();
	}
	
/**
 * Same as find all but checks if files exists in file system
 *
 * @param string $state 
 * @param string $query 
 * @param string $results 
 * @return array
 * @author Fran Iglesias
 */
	function _findChecked($state, $query, $results = array()) {
		if ($state === 'before') {
			return $query;
		}
		foreach ($results as $key => $result) {
			$results[$key]['Upload']['exists'] = file_exists($result['Upload']['fullpath']);
		}
		return $results;
	}
	
	public function deleteRelatedFiles($id = null)
	{
		$this->setId($id);
		$paths = $this->relatedFiles();
		if (empty($paths)) {
			return true;
		}
		foreach ($paths as $path) {
			if (!empty($path) && file_exists($path)) {
				unlink($path);
			}
		}
		return true;
	}
	
/**
 * Deletes the file associated with a record
 *
 * @param string $id 
 * @return void
 */
	function deleteFile($id = null) {
		return $this->deleteRelatedFiles($id);
	}

/**
 * Checks if the upload exists in filesystem
 *
 * @return boolean true if exists of false if not
 **/
	function existsInFS ($id = null) {
		$this->setId($id);
		return file_exists($this->field('fullpath'));
	}

/**
 * Attach the upload to a different model
 *
 * @param AppModel $Model to attach 
 * @return void
 */
	// function attachToModel($model, $fk, $id = null) {
	// 	$this->setId($id);
	// 	$this->saveField('model', $model);
	// 	$this->saveField('foreign_key', $fk);
	// }

	public function attach(AppModel $Model)
	{
		$this->set(array(
			'model' => $Model->alias,
			'foreign_key' => $Model->getID()
		));
		$this->save();
	}

/**
 * Creates an upload record from a file in FS
 *
 * @param string $path The fullpath of the file
 * @param string $data Data for the Upload Record
 * @return void
 */

	function createFromFile($path, $data = false) {
		if (!is_array($data) || key($data) != 'Upload') {
			$data = array('Upload' => $data);
		}
		return $this->fromFile($path, null, $data);
	}

	private function fromFile($path, $id = null, $data = array()) {
		if (!file_exists($path)) {
			throw new InvalidArgumentException (sprintf('File not found: %s.', $path), 1);
		}
		App::import('Lib', 'fi_file/FiId3');
		$id3 = new FiId3($path);
		try {
			$this->setId($id);
		} catch (Exception $e) {
			// This is a new file
			$this->create();
		}
		$this->set($id3->info());
		$this->set($data);
		if (!$this->save()) {
			throw new RuntimeException (sprintf('File %s not saved.', $path), 1);
		}
		return true;
	}

/**
 * Reloads upload data to the model record
 *
 * @param string $id 
 * @return void
 */
	public function refresh($id)
	{
		$this->setId($id);
		$fields = array(
			'name',
			'description',
			'model',
			'foreign_key',
			'author',
			'url',
			'enclosure',
			'order',
			'created',
			'fullpath'
		);
		$this->read($fields);
		$this->fromFile($this->data['Upload']['fullpath'], $this->id, $this->data);
		// Remove cache files
		foreach ($this->relatedFiles($id) as $path) {
			if ($path == $this->data['Upload']['fullpath']) {
				continue;
			}
			unlink($path);
		}
	}
	
/**
 * Retrieves the list of relates files for an image upload or the file.
 *
 * We need to use the base path for the image to avoid deleting files with the same name uploaded at other date 
 * given the way we manage the clutter of uploads on a daily basis. Then we use findRecursive to retrieve all 
 * thumb files derived from upload
 *
 * @param string $id 
 * @return array of full paths to files
 */
	public function relatedFiles($id = false)
	{
		$this->setId($id);
		$this->read(array('path', 'name', 'type', 'fullpath'));
		if ($this->isImage()) {
			return array($this->data['Upload']['fullpath']);
		}
		$path = pathinfo($this->data['Upload']['fullpath'], PATHINFO_DIRNAME);
		$name = pathinfo($this->data['Upload']['fullpath'], PATHINFO_BASENAME);
		$folder = new Folder($path);
		return $folder->findRecursive('_?'.$name.'$');
	}
	
	
	private function isImage()
	{
		return substr($this->data['Upload']['type'], 0, 5) !== 'image';
	}
	
	public function getType()
	{
		return $this->data['Upload']['type'];
	}

	
/**
 * Purgue Upload records that lost their files
 *
 * @return void
 */
	function purge() {
		$page = 20;
		$total = $this->find('count');
		$pages = floor($total / $page);
		if ($total % $page) {
			$pages++;
		}
		$toDelete = array();
		for ($i=0; $i < $pages; $i++) { 
			$options = array(
				'fields' => array('id', 'fullpath'),
				'limit' => $page, 
				'offset' => ($i * $page)
				);
			$uploads = $this->find('all', $options);
			foreach ($uploads as $upload) {
				if (!file_exists($upload['Upload']['fullpath'])) {
					$toDelete[] = $upload['Upload']['id'];
				}
			}
		}
		$this->deleteAll(array('id' => $toDelete));
		return count($toDelete);
	}
	

/**
 * Get max order field given model-fk
 *
 * @param $model string the Model
 * @param $fk string the Id of the Model / foreign_key
 */
	public function maxOrder($model, $fk)
	{
		$result = $this->find('first', array(
			'fields'=>array('MAX(Upload.order) AS last_order'),
			'conditions' => array(
				'Upload.model' => $model,
				'Upload.foreign_key' => $fk
				)
			));
		if (!$result) {
			return 0;
		}
		return $result[0]['last_order'];
	}
	
}
?>