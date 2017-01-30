<?php
class Entry extends AggregatorAppModel {
	var $name = 'Entry';
	var $displayField = 'title';
	
	var $order = 'Entry.pubDate DESC';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Feed' => array(
			'className' => 'Aggregator.Feed',
			'foreignKey' => 'feed_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['planet'] = true;
		$this->_findMethods['last'] = true;
	}
	
	
/**
 * Update entries for a Feed. The method manages existent entries, and label them
 * as updated or new as needed
 *
 * @param string $id 
 * @return void
 */
	public function refresh(&$Feed) {
		if (!isset($Feed->data['Entry'])) {
			return false;
		}
		$entries = $Feed->data['Entry'];
		if (!$entries) {
			return false;
		}

		$this->updateAll(array('status' => null), array('Entry.feed_id' => $Feed->id));
		foreach ($entries as $entry) {
			$existing = $this->findByGuid($entry['guid']);
			// Check if the entry is new
			if (!$existing) {
				$entry['status'] = 'new';
				$this->create($entry);
				$this->save();
				continue;
			}
			// Check if the entry exists and it is not changed
			if ($existing['Entry']['md5'] == $entry['md5']) {
				continue;
			}
			$entry['id'] = $existing['Entry']['id'];
			$entry['status'] = 'updated';
			$this->create($entry);
			$this->save();
		}
		
		return true;
	}

	public function _findPlanet($state, $query, $results = array()) {
		if ($state === 'before') {
			$extraQuery = array(
				'fields' => array(
					'Entry.*',
					'Feed.*'
					),
				'joins' => array(
					array('table' => 'feeds',
						'alias' => 'Feed',
						'type' => 'LEFT',
						'foreignKey' => FALSE,
						'conditions' => array(
							'Feed.id = Entry.feed_id',
						)
					),
					array('table' => 'planets',
						'alias' => 'Planet',
						'type' => 'LEFT',
						'foreignKey' => FALSE,
						'conditions' => array(
							'Planet.id = Feed.planet_id'
						)
					)
				),
				'conditions' => array(
					'Feed.approved' => true
				)
			);
			return Set::merge($query, $extraQuery);
		}
		// Results manipulation
		return $results;
	}
	
	public function _findLast($state, $query, $results = array()) {
		if ($state === 'before') {
			$extraQuery = array(
				'fields' => array(
					'Entry.id',
					'Entry.title',
					'Entry.url',
					'Entry.pubDate',
					'Entry.status'
					),
				'contain' => array(
					'Feed' => array(
						'fields' => array(
							'title',
							'url',
							'slug'
							)
						)
					)
				);
			$query = Set::merge($query, $extraQuery);
			return $query;
		}
		// Results manipulation
		return $results;
	}

	public function deleteOutdated()
	{
		$date = date('Y-m-d', strtotime('-3 month'));
		return $this->deleteAll(array('pubDate <=' => $date));
	}
	
}
?>