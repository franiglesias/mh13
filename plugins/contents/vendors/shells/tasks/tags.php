<?php


App::import('Vendor', 'AppShell');

/**
 * Utility to remove unused Tags from the database.
 *
 * @return void
 */	

class TagsTask extends AppShell
{
	var $uses = array('Tags.Tag');
	
	function execute()
	{
		$this->out('Tags Cleaner Utility');
		$this->hr();
		$query = array(
			'fields' => array('Tag.id', 'Tag.keyname'),
			'joins' => array(
				array(
					'table' => 'tagged',
					'alias' => 'Tagged',
					'type' => 'left',
					'conditions' => array('Tag.id = Tagged.tag_id')
				)
			),
			'conditions' => array('Tagged.id' => null)
		);
		$result = $this->Tag->find('all', $query);
		$number = count($result);
		if (!$number) {
			$this->out('There are no unused tags');
			$this->hr();
			return;
		}
		$ids = Set::extract('/Tag/id', $result);
		$keys = Set::extract('/Tag/keyname', $result);
		$this->out(sprintf('Found %s unused tags', $number));
		$this->out(implode(', ', $keys));
		$this->confirm('Are you sure?');
		$this->Tag->deleteAll(array('Tag.id' => $ids));
		$this->out(sprintf('%s tags deleted', $number));
		$this->hr();
	}

}


?>

