<?php

class Circular extends CircularsAppModel {
	
	const DRAFT = 0;
	const PUBLISHED = 1;
	const ARCHIVED = 2;
	const REVOKED = 3;
	
	var $name = 'Circular';
	
	var $displayField = 'title';
	
	var $virtualFields = array(
		'filename' => "CONCAT(CONCAT_WS('-', 'circular',LPAD(Circular.id, 6, '000000'),Circular.pubDate),'.pdf')"
	);
	
	var $State;
	var $actsAs = array(
		'Translate' => array(
			'title' => 'TitleTranslations',
			'content' => 'ContentTranslations',
			'extra' => 'ExtraTranslations',
			'signature' => 'SignatureTranslations',
			'addressee' => 'AddresseeTranslations'
		),
		'Ui.Multilingual',
		'Ui.Duplicable'
	);
	
	var $translateModel = 'Circulars.CircularI18n';

	var $belongsTo = array(
		'CircularType' => array(
			'className' => 'Circulars.CircularType',
			'foreignKey' => 'circular_type_id',
		),
		'CircularBox' => array(
			'className' => 'Circulars.CircularBox',
			'foreignKey' => 'circular_box_id',
		),
		'Creator' => array(
			'className' => 'Access.User',
			'foreignKey' => 'creator_id',
		),
		'Publisher' => array(
			'className' => 'Access.User',
			'foreignKey' => 'publisher_id',
		),
		'Revoker' => array(
			'className' => 'Access.User',
			'foreignKey' => 'revoker_id',
		),
		'Archiver' => array(
			'className' => 'Access.User',
			'foreignKey' => 'archiver_id',
		)
	);
	
	var $hasOne = array(
		'Event' => array(
			'className' => 'Circulars.Event',
			'foreignKey' => 'circular_id',
		),
	);
	
	var $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'on' => 'update'
			)
		),
		'addressee' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'on' => 'update'
			)
		),
		'pubDate' => array(
			'notEmtpy' => array(
				'rule' => 'notEmpty',
				'on' => 'update'
			)
		),
		'pubDate-alt' => array(
			'notEmtpy' => array(
				'rule' => 'notEmpty',
				'on' => 'update'
			)
		)
		
	);
	
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['current'] = true;
		$this->_findMethods['widget'] = true;
		$this->_findMethods['year'] = true;
	}
	
	
	function afterSave($created) {
		$this->refreshCache();
	}

	private function refreshCache()
	{
		$this->_deleteCache('circulars_current');
		$this->_deleteCache('events_next');
	}

    function afterDelete()
    {
        $this->refreshCache();
    }
	
/**
 * Manage duplication of Event and Addressee in Circular that has one attached
 *
 * @return void
 */
	public function afterDuplicate() {
		if($e = $this->Event->find('first', array('conditions' => array('circular_id' => $this->oldId)))) {
			$this->Event->id = $this->Event->duplicate($e['Event']['id']);
			$this->Event->saveField('circular_id', $this->id, false);
		}
	}
	
	public function _findYear($state, $query, $results = array())
	{
		if ($state === 'before') {
			$fields = array(
				'Circular.id',
				'Circular.title',
				'Circular.addressee',
				'Circular.circular_type_id',
				'Circular.pubDate',
				'Circular.web',
				'Circular.status'
			);
			$conditions = array(
				'or' => array(
					'Circular.pubDate >=' => Configure::read('SchoolYear.starts'),
					'Circular.expiration >=' => Configure::read('SchoolYear.starts'),
					'Circular.expiration' => null,
					'Circular.status' => 0
				),
			);
			$order = array('Circular.pubDate' => 'desc');
			$query = Set::merge($query, compact('fields', 'conditions', 'order'));
			return $query;
		}
		return $results;
	}
	
	
	public function _findCurrent($state, $query, $results = array()) {
		if ($state === 'before') {
			$fields = array(
				'Circular.id',
				'Circular.title',
                'Circular.content',
				'Circular.addressee',
				'Circular.pubDate',
				'Circular.filename',
				'CircularType.title',
				'CircularBox.title',
			);
			$conditions = array(
				'Circular.pubDate <= CURDATE()',
				'Circular.status' => Circular::PUBLISHED,
				'Circular.web' => true
			);
			$contain = array(
				'CircularType',
				'CircularBox',
			);
			$order = array(
				'Circular.pubDate' => 'DESC'
			);
			$query = Set::merge($query, compact('fields','conditions', 'contain', 'order'));
			return $query;
		}
		return $results;
	}
	

	public function _findWidget($state, $query, $results = array()) {
		if ($state === 'before') {
			$fields = array(
				'Circular.id',
				'Circular.title',
				'Circular.addressee',
				'Circular.pubDate',
				'Circular.filename',
				'CircularType.title',
			);
			$conditions = array(
				'Circular.pubDate BETWEEN CURDATE() - INTERVAL 15 DAY AND CURDATE()',
				'Circular.status' => Circular::PUBLISHED,
				'Circular.web' => true
			);
			$contain = array(
				'CircularType',
			);
			$order = array(
				'Circular.pubDate' => 'DESC'
			);
			$query = Set::merge($query, compact('fields','conditions', 'contain', 'order'));
			return $query;
		}
		return $results;
	}

/**
 * Reads current circular data
 *
 * @param string $id
 *
 * @return circular data
 */
	public function load($id = null)
	{
		$this->setId($id);
		$contains = array(
			'CircularType', 'CircularBox', 'Event'
		);
		$this->contain($contains);
		if ($this->Behaviors->attached('Translate')) {
			$circular = $this->get(null, $this->id);
			$event = $this->Event->get(null, $circular['Event']['id']);
			$circular['Event'] = $event;
		} else {
			$circular = $this->read(null, $this->id);
		}
		return $circular;
	}

	public function retrieve($id)
	{
		$this->setId($id);
		$contains = array(
			'CircularType', 'CircularBox', 'Event'
		);
		$this->contain($contains);
		if ($this->Behaviors->attached('Translate')) {
			$this->data = $this->get(null);
			$event = $this->Event->get(null, $this->data['Event']['id']);
			$this->data['Event'] = $event;
		} else {
			$this->data = $this->read(null);
		}
	}
	
	public function deleteFile($id = null)
	{
		$file = new File($this->getFilePath($id));
		$file->delete();
	}

    /**
     * Returns file path to the PDF circular file
     *
     * @param string $id
     *
     * @return string the file path
     */
    public function getFilePath($id = null)
    {
        $this->setId($id);
        return 'files' . DS . $this->field('filename');
    }
	
	public function init($type, $user_id)
	{
		$new = array();
		foreach ($this->translatedFields() as $field) {
			$new[$field]['spa'] = '';
			$new[$field]['glg'] = '';
		}

		$new = array_merge($new, array(
			'circular_type_id' => $type,
			'creator_id' => $user_id,
			'expiration' => Configure::read('SchoolYear.ends'),
			'pubDate' => date('Y-m-d'),
			'web' => false,
			'event_publish' => false
		));
		$this->set($new);
	}
	
	public function setToDraft($publisher_id)
	{
		$this->saveField('status', Circular::DRAFT);
		$this->Event->saveField('publish', true, array(
			'Event.circular_id' => $this->id
		));
		$this->changeEventPublishedState(false);
	}

    private function changeEventPublishedState($state)
    {
        if ($this->field('publish_event') == false) {
            $state = false;
        }
        $this->Event->id = Set::extract('/Event/id', $this->Event->find('first', array(
            'fields' => array(
                'id'
            ),
            'conditions' => array(
                'Event.circular_id' => $this->id
            )
        )));
        $this->Event->saveField('publish', $state);
    }
	
	public function setToPublished($publisher_id)
	{
		$this->set(array(
			'status' => Circular::PUBLISHED,
			'publisher_id' => $publisher_id
		));
		$this->save(null, false, false);
		$this->changeEventPublishedState(true);
	}

    public function setToArchived($publisher_id)
	{
		$this->set(array(
			'status' => Circular::ARCHIVED,
			'archiver_id' => $publisher_id
		));
		$this->save(null, false, false);
		$this->changeEventPublishedState(true);
	}

    public function setToRevoked($publisher_id)
	{
		$this->set(array(
			'status' => Circular::REVOKED,
			'revoker_id' => $publisher_id
		));
		$this->save(null, false, false);
		$this->changeEventPublishedState(false);
	}
	
}
?>
