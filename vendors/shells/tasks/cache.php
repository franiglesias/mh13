<?php

/**
 * Delete all files in the cache folder. Use when changes in models, stalling views and other problems
 *
 * @return void
 */	

class CacheTask extends Shell
{
	var $protectFolders = array(
		'\.svn',
	);
	
	public function execute()
	{
		$this->out('Cache cleaner');
		$this->hr();
		$this->out('Deletes all files in cache folder.');
		$this->hr();
		$path = APP.'tmp'.DS.'cache'.DS;
		$Folder = new Folder($path);
		$files = $Folder->findRecursive();
		if (!count($files)) {
			$this->out('There are no files to clean.');
			$this->hr();
			return;
		}
		$count = 0;
		foreach ($files as $filePath) {
			$fileName = basename($filePath);
			$exclude = implode('|', $this->protectFolders);
			if (preg_match('/\/'.$exclude.'\//', $filePath) || strpos($fileName, '.') === 0) {
				continue;
			}
			if (!in_array('dry', $this->args)) {
				$this->out('Deleting '.$filePath);
				unlink($filePath);
				$count++;
			}
		}
		$this->hr();
		$this->out(sprintf('%s files Deleted', $count));
		$this->hr();
	}
}


?>

