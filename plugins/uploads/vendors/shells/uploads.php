<?php

/**
* Cake Console Shell to manage uploads
*/

App::import('Lib', 'Uploads.UploadedFile');
App::import('Lib', 'Uploads.file_binder/FileBinder');
App::import('Lib', 'Uploads.file_dispatcher/FileDispatcher');


class UploadsShell extends Shell
{
	var $uses = array('Uploads.Upload', 'Contents.Channel', 'Contents.Item', 'Access.User', 'Resumes.Resume', 'Resumes.Merit');
	
	/**
	 * Subfolders to exclude in clean method
	 *
	 * @var array
	 */
	var $protectFolders = array(
		'thumb',
		'\.svn',
		'icons',
		'bookmarks',
		'assets'
	);
	
	var $deleted;
	var $errors;
	var $skipped;
	
	function main()
	{
		$this->out('Uploads management');
		$this->hr();
		$this->out();
		$this->out('Clean orphaned files:');
		$this->out();
		$this->out('     cake uploads clean image|files');
		$this->out('     Example: cake uploads clean images');
		$this->out('     options:');
		$this->out('          dry: don\'t delete the files. Example: cake uploads clean files dry',2);
		$this->out();
		$this->out('Purgue Uploads records that lost their physical files:');
		$this->out();
		$this->out('     cake uploads purgue');
	}
	
	
/**
 * Scans images or files folders in the webroot searching for orphaned files and deleting them
 * 
 * To protect files used as assets in css or javascript or so, store them in an assets folder
 * or in the webroot theme folder.
 *
 * @return void
 */	
	public function clean()
	{
		$this->out('Uploads Cleaner');
		$this->hr();
		$this->out('Deletes unused files.');
		$this->hr();
		if (in_array('images', $this->args)) {
			$path = IMAGES;
		} elseif (in_array('files', $this->args)) {
			$path = WWW_ROOT.'files';
		} else {
			$this->error('Usage: cake uploads clean images|files');
		}
		
		$Folder = new Folder($path);
		$files = $Folder->findRecursive();
		
		$total = count($files);
		$this->deleted = $this->skipped = $this->errors = 0;
		$this->out(sprintf('Processing %s files...', $total));
		
		foreach ($files as $filePath) {
			$fileName = basename($filePath);

			// Skip folders
			$exclude = implode('|', $this->protectFolders);
			if (preg_match('/\/'.$exclude.'\//', $filePath) || strpos($fileName, '.') === 0) {
				continue;
			}
			
			$result = $this->Upload->find('count', array('conditions' => array('fullpath' => $filePath)));
			
			// Skip file if exists in Upload model
			if ($result) {
				$this->skipped++;
				continue;
			}
			
			// Exclude files used in other Models
			if ($this->_checkModels($fileName)) {
				$this->skipped++;
				continue;
			}
			
			$msg = 'Not found record for: '.$filePath;
			$this->out($msg);
			
			$this->_deleteFile($filePath);
			
			// Find thumbs for images
			if ($path != IMAGES) {
				continue;
			}

			$thumbs = $Folder->findRecursive('.*'.$fileName);
			foreach ($thumbs as $thumb) {
				$this->_deleteFile($thumb);
			}
		}
		// Report results
		$this->hr();
		if (in_array('dry', $this->args)) {
			$this->out('* This was a dry run, no files were deleted. *');
			$this->hr();
		}
		$this->out('Total files: '.$total);
		$this->out('Deleted:     '.($this->deleted - $this->errors));
		$this->out('Skipped:     '.$this->skipped);
		$this->out('Errors:      '.$this->errors);
		if ($path == IMAGES) {
			$this->out('  (*) Note: Total files includes thumbnails.');
		}
		$this->hr();
	}
	
	protected function _deleteFile($filePath)
	{
		$this->deleted++;
		if (in_array('dry', $this->args)) {
			$this->out('   ---> (Not) Deleting file '.$filePath);
			return true;
		}

		$this->out('   ---> Deleting file '.$filePath);

		if (!unlink($filePath)) {
			$this->err('    ** Couldn\'t delete file: '.basename($filePath));
			$this->errors++;
			return false;
		}

		return true;
	}
	
	public function purgue()
	{
		$this->out('Uploads Purgue');
		$this->hr();
		$this->out('Deletes Upload records that lost their files.');
		$this->hr();
		
		$paths = $this->Upload->find('all', array(
			'fields' => array('id', 'fullPath')
			)
		);
		$total = count($paths);
		if (!$total) {
			$this->error('There are no records.');
			return false;
		}
		
		$delete = array();
		foreach ($paths as $record) {
			if (!file_exists($record['Upload']['fullPath'])) {
				$this->out(sprintf('Upload id: %s lost file %s', $record['Upload']['id'], $record['Upload']['fullPath']));
				$delete[] = $record['Upload']['id'];
			}
		}
		if (empty($delete)) {
			$this->error('There are no records to purgue.');
			return false;
		}
		
		$toDelete = count($delete);
		
		if (!in_array('dry', $this->args)) {
			$this->Upload->deleteAll(array('Upload.id' => $delete));
			$this->out(sprintf('%s records were deleted', $toDelete));
		} else {
			$this->out('This was a dry run. No records deleted.');
		}
	}
	
	
/**
 * Checks if a file is used in a model, looking into certain fields
 *
 * @param string $fileName 
 * @return boolean false if the file is not used
 */	

	protected function _checkModels($fileName)
	{
		if ($this->Item->find('count', array('conditions' => array('image LIKE' => '%'.$fileName)))) {
			return true;
		}

		if ($this->Channel->find('count', array('conditions' => array('image LIKE' => '%'.$fileName)))) {
			return true;
		}

		if ($this->Channel->find('count', array('conditions' => array('icon LIKE' => '%'.$fileName)))) {
			return true;
		}

		if ($this->User->find('count', array('conditions' => array('photo LIKE' => '%'.$fileName)))) {
			return true;
		}
		
		if ($this->Resume->find('count', array('conditions' => array('photo LIKE' => '%'.$fileName)))) {
			return true;
		}

		if ($this->Merit->find('count', array('conditions' => array('file LIKE' => '%'.$fileName)))) {
			return true;
		}


		return false;
	}
	
	public function move()
	{
		$uploads = $this->Upload->find('all', array('fields' => array('id', 'model', 'foreign_key', 'fullpath', 'type')));
		$total = $this->Upload->find('count');
		$count = 0;
		foreach ($uploads as $upload) {
			$newPath = $this->computePath($upload);
			if (strcmp($newPath, $upload['Upload']['fullpath']) != 0) {
				$this->out(sprintf('Change Upload %s:'.chr(10).'%s'.chr(10).'%s'.chr(10),
				 	$upload['Upload']['id'],
					$upload['Upload']['fullpath'], 
					$newPath
					));
				$this->moveUpload($upload);
				$count++;
			} else{
				$this->out(sprintf('Skipping Upload %s', $upload['Upload']['id']));
			}
		}
		$this->out(sprintf('Moved %s of %s files', $count, $total));
		
	}
	
	protected function computePath($upload)
	{
		$path = Configure::read('Uploads.base');
		if (strpos($upload['Upload']['type'], 'image') === 0) {
			$path .= 'img/';
		} else {
			$path .= 'files/';
		}
		$path .= $upload['Upload']['model'].'/';
		$path .= $upload['Upload']['foreign_key'].'/';
		return trim($path.basename($upload['Upload']['fullpath']));
	}
	
	private function moveUpload($upload)
	{
		$this->Upload->setId($upload['Upload']['id']);
		$File = new UploadedFile($this->Upload->field('fullpath'));
		$params = array(
			'upload_id' => $this->Upload->getID(),
			'copy' => true
		);
		$D = new FileDispatcher(Configure::read('Uploads.base'));
		$Binder = new FileBinder($D, $params);
		$Binder->bind($File);
	}

	
}


?>