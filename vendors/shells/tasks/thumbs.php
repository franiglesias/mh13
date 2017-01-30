<?php

/**
 * Delete all files in the cache folder. Use when changes in models, stalling views and other problems
 *
 * @return void
 */	

class ThumbsTask extends Shell
{
	var $protectFolders = array(
		'\.svn',
	);
	
	public function execute()
	{
		$this->out('Thumbnail Folders cleaner');
		$this->hr();
		$this->out('Deletes all thumbnail folders.');
		$this->hr();
		$path = Configure::read('Site.webroot').IMAGES_URL;
		$this->out($path);
		$this->hr();
		$Folder = new Folder($path);
		$files = $Folder->tree($path, false, 'dir');
		$thumbFolders = array();
		foreach ($files as $file) {
			if (preg_match('/thumb$/', $file)) {
				$thumbFolders[] = $file;
			}
		}
		if (!count($thumbFolders)) {
			$this->out('There are no folders to clean.');
			$this->hr();
			return;
		}
		$count = $total = 0;
		foreach ($thumbFolders as $tFolder) {
			if (!in_array('dry', $this->args)) {
				$this->out('Deleting '.$tFolder);
				if ($Folder->delete($tFolder)) {
				 	$count++;
				}
			} else {
				$this->out('Skipping '.$tFolder);
			}
			$total++;
		}
		$this->hr();
		$this->out(sprintf('%s folders deleted', $count));
		$this->out(sprintf('%s folders considered', $total));
		
		$this->hr();
	}
}


?>

