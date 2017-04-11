<?php

App::import('Model', 'Circulars.Circular');

class Event extends CircularsAppModel {
	var $name = 'Event';
	var $displayField = 'title';
	
	var $actsAs = array(
		'Translate' => array(
			'title' => 'TitleTranslations',
			'description' => 'DescriptionTranslations',
			'place' => 'PlaceTranslations'
		),
		'Ui.Multilingual',
		'Ui.Duplicable'
	);
	
	var $belongsTo = array(
		'Circular' => array(
			'className' => 'Circulars.Circular',
			'foreignKey' => 'circular_id',
		)
	);
	
	var $virtualFields = array(
		'type' => 'IF(ISNULL(Event.endDate), \'day\', \'period\')',
		'subType' => 'IF(isnull(Event.startTime), \'all\', IF(isnull(Event.endTime),\'start\',\'limited\'))',
	);
	
	var $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'startDate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'startDate-alt' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		)
	);
	
	var $translateModel = 'Circulars.EventI18n';
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['next'] = true;
		$this->_findMethods['today'] = true;
		$this->_findMethods['index'] = true;
	}

	function beforeSave($options) {
		//Ensure endDate is not saved when empty
		if (empty($this->data['Event']['endDate'])) {
			unset($this->data['Event']['endDate']);
		}
		return true;
	}
	
	function afterSave($created) {
		$this->refreshCache();
	}

	private function refreshCache()
	{
		$this->_deleteCache('events_next');
		$this->_deleteCache('events_today');
	}

    function afterDelete()
    {
        $this->refreshCache();
    }
	
/**
 * Custom find method to retrieve valid events to show as Next Events. This should
 * take care about Circular status if present
 *
 * @param string $state
 * @param string $query
 * @param string $results
 *
 * @return array the data
 */
	public function _findNext($state, $query, $results = array()) {
		if ($state === 'before') {
			$fields = array(
				'Event.id',
				'Event.type',
				'Event.description',
				'Event.continuous',
				'Event.subType',
				'Event.startTime',
				'Event.endTime',
				'Event.startDate',
				'Event.endDate',
				'Circular.id',
				'Event.title',
			);
			$conditions = array(
				'or' => array(
					'Event.startDate >= CURDATE()',
					'Event.startDate < CURDATE() AND Event.endDate >= CURDATE() AND Event.endDate IS NOT NULL'
				),
				'Event.publish' => true,
				array(
					'or' => array(
						'Circular.id' => null,
						array(
							'Circular.status' => Circular::PUBLISHED,
							'Circular.publish_event' => true,
							'Circular.pubDate <= CURDATE()'
						)
					)
				)
			);
			$order = array(
				'Event.startDate' => 'ASC',
				'Event.startTime' => 'ASC'
			);
			$contain = array('Circular');
			return Set::merge($query, compact('fields', 'conditions', 'order', 'contain'));
		}
		return $results;
	}

/**
 * Custom find to retrieve Events for Current Date
 *
 * @param string $state
 * @param string $query
 * @param string $results
 *
 * @return void
 */	
	public function _findToday($state, $query, $results = array()) {
		if ($state === 'before') {
			$conditions = array(
				'Event.publish' => true,
				'or' => array(
					'Event.startDate = CURDATE()',
					'Event.startDate < CURDATE() AND Event.endDate >= CURDATE() AND Event.endDate IS NOT NULL'
				),
				array(
					'or' => array(
						'Circular.id' => null,
						array(
							'Circular.status' => Circular::PUBLISHED,
							'Circular.web' => true,
							'Circular.pubDate <= CURDATE()'
						)
					)
				)
			);
			$order = array(
				'Event.startDate' => 'ASC',
				'Event.startTime' => 'ASC'
			);
			$contain = array('Circular');
			return Set::merge($query, compact('conditions', 'order', 'contain'));
		}
		return $results;
	}
	
	public function _findIndex($state, $query, $results = array())
	{
		if ($state === 'before') {
			$fields = array(
				'Event.id', 'Event.title', 'Event.startDate', 'Event.endDate', 'Event.type', 'Event.subType', 'Event.publish'
			);
			$conditions = array(
				'or' => array(
					'Event.startDate >= CURDATE()',
					'Event.endDate >= CURDATE() AND Event.endDate IS NOT NULL'
				)
			);
			return Set::merge($query, compact('fields', 'conditions'));
		}
		return $results;
	}
}
?>
