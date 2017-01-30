<?php
class Resume extends ResumesAppModel {
	var $name = 'Resume';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Merit' => array(
			'className' => 'Merit',
			'foreignKey' => 'resume_id',
			'dependent' => true,
			'exclusive' => true,
		)
	);
	
	var $belongsTo = array(
		'Position' => array(
			'className' => 'Position',
			'foreignKey' => 'position_id',
		)
	);
	
	var $virtualFields = array(
	    'fullname' => 'CONCAT(Resume.firstname, " ", Resume.lastname)',
		'fullcity' => 'CONCAT(Resume.cp, " - ", Resume.city, " (",Resume.province,")")',
		'fulladdress' => 'IF(address2,concat(address, "<br />", address2),address)'
	);
	
	var $displayField = 'email';
	
	// Model Behaviors
	// photo is an uploadable file
	
	var $actsAs = array(
		'Tickets.Ticketable',
		'Uploads.Upable' => array(
			'photo' => array( 
				'mode' => 'url',
				'private' => false,
				'imagePostprocess' => array(
					'normalize' => array(
						'width' => 128,
						'height' => 128,
						)
					)
				)
			)
	);

	// Validation rules for data entry
	
	var $validate = array(
		'password' => array(
			'rule' => array('match', 'confirm_password', 'sha1', true),
			'message' => 'passwords doesn\'t match',
			'allowEmpty' => true
			),
		'email' => array(
			array(
				'rule' => 'isUnique',
				'allowEmpty' => false
			),
			array(
				'rule' => 'email',
				'allowEmpty' => false,
				),
			array(
				'rule'  => array('match', 'confirm_email'),
				'message' => 'emails doesn\'t match',
				'on' => 'create'
				)
			),
		'confirm_password' => array(
			'rule' => 'notEmpty',
			'on' => 'create'
			)
		);
		
	public function  __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['search'] = true;
		$this->_findMethods['subject'] = true;
	}

	public function beforeValidate()
	{
		// Hashes the password (simulates the use of Auth)
		if (!empty($this->data['Resume']['password'])) {
			$this->data['Resume']['password'] = Security::hash($this->data['Resume']['password'], 'sha1', true);
		}
		return true;
	}
	
	public function authorized($data)
	{
		$conditions = array(
			'email' => $data['Resume']['email'],
			'password' => Security::hash($data['Resume']['password'], 'sha1', true)
		);
		$resume = $this->find('first', compact('conditions'));
		if (!empty($resume)) {
			unset($resume['Resume']['password']);
		}
		return $resume;
	}
	
	public function readCV($id = null)
	{
		if (!$this->id && !$id) {
			return false;
		}
		
		if ($id) {
			$this->id = $id;
		}
		App::import('Model', 'Resumes.MeritType');
		$MT = ClassRegistry::init('MeritType');
		$types = $MT->find('all');
		$this->unbindModel(array('hasMany' => array('Merit')));
		
		foreach ($types as $type) {
			$this->_bindMeritType($type);
		}
		
		$this->recursive = 1;
		$cv = $this->read(null);
		return $cv;
	}
	
	public function search($terms)
	{
		$conditions = array(
			"MATCH(Merit.title,Merit.remarks) AGAINST('$terms' IN BOOLEAN MODE)"
		);
		
		$joins = array(
			array(
				'table' => 'merits',
				'alias' => 'Merit',
				'type' => 'left',
				'conditions' => array(
					'Resume.id = Merit.resume_id'
				)
			)
		);
		
		$results = $this->find('all', compact('conditions', 'joins'));
		return $results;
	}
	
	public function _findSearch($state, $query, $results = array())
	{
		if ($state === 'before') {
			if (!is_array($query)) {
				$terms = $query;
			} else {
				$terms = $query['terms'];
			}
			$fields = array(
				'DISTINCT Resume.id',
				'Resume.email',
				'Resume.firstname',
				'Resume.lastname',
				'Resume.phone',
				'Resume.mobile',
				'Resume.photo',
				'Resume.fullname',
				'Resume.modified'
			);
			
			$conditions = array(
				"MATCH(Merit.title,Merit.remarks) AGAINST('$terms' IN BOOLEAN MODE)"
			);

			$joins = array(
				array(
					'table' => 'merits',
					'alias' => 'Merit',
					'type' => 'left',
					'foreignKey' => FALSE,
					'conditions' => array(
						'Resume.id = Merit.resume_id'
					)
				)
			);

			$extraQuery = compact('fields', 'conditions', 'joins');
			return Set::merge($query, $extraQuery);
		}
		
		return $results;
	}


	public function _findSubject($state, $query, $results = array())
	{
		if ($state === 'before') {
			if (!is_array($query)) {
				$terms = $query;
			} else {
				$terms = $query['terms'];
			}
			
			$conditions = array(
				'Merit.title LIKE' => '%'.$terms.'%'
			);

			$joins = array(
				array(
					'table' => 'merits',
					'alias' => 'Merit',
					'type' => 'left',
					'foreignKey' => FALSE,
					'conditions' => array(
						'Resume.id = Merit.resume_id'
					)
				),
				array(
					'table' => 'merit_types',
					'alias' => 'MeritType',
					'type' => 'left',
					'foreingKey' => FALSE,
					'conditions' => array(
						'Merit.merit_type_id = MeritType.id',
						'MeritType.alias' => 'Habilitacion'
					)
				)
			);

			$group = array(
				'Resume.id'
			);

			$extraQuery = compact('conditions', 'joins', 'group');
			return Set::merge($query, $extraQuery);
		}
		
		return $results;
	}



	// Forgot and recover password
	
	
	public function forgot($email=false)
	{
		if (!$email) {
			throw new InvalidArgumentException(__('Not enough data', true));
		}
		$conditions['email'] = $email;
		$resume = $this->find('all', compact('conditions'));
		if (!$resume or count($resume) > 1) {
			throw new OutOfBoundsException(__d('resumes', 'Unable to found a valid Resume with the data provided.', true));
		}
		$resume = array_shift($resume);
		$this->id = $resume['Resume']['id'];
		$this->set($resume);
		$ticket = $this->createTicket('recover', $this->id);
		if (!$ticket) {
			throw new RuntimeException(__d('access', 'Unable to get a ticket to recover password.', true));
		}
		return $ticket;
	}
	
	
	public function recover($id = false)
	{
		if (!$this->id && !$id) {
			throw new InvalidArgumentException(__('A valid ID is needed to perform this model method.', true));
		}
		if ($id) {
			$this->id = $id;
		}
		App::import('Lib', 'PasswordGenerator');
		$PasswordGenerator = new PasswordGenerator();
		$password = $PasswordGenerator->readable();
		$hash = Security::hash($password, 'sha1', true);
		$this->saveField('password', $hash, array('validate' => false, 'callbacks' => false));
		return $password;
	}
	
/**
 * A % of fields completed
 *
 * @param string $id 
 * @return float % of fields completed
 */	
	public function isComplete($id = null)
	{
		if (!$this->id && !$id) {
			throw new OutOfBoundsException();
		}
		if ($id) {
			$this->id = $id;
		}
		$fields = array_keys($this->_schema);
		$except = array(
			'id',
			'address2',
			'created',
			'modified',
			'photo'
		);
		$fields = array_diff($fields, $except);
		$isComplete = true;
		$data = $this->read(null, $id);
		$count = 0;
		foreach ($fields as $field) {
			if (!empty($data['Resume'][$field])) {
				$count++;
			}
		}
		return $count*100/count($fields);
	}

	public function stats($id)
	{
		if (!$this->id && !$id) {
			throw new OutOfBoundsException();
		}
		if ($id) {
			$this->id = $id;
		}
		
		
		App::import('Model', 'Resumes.MeritType');
		$MT = ClassRegistry::init('MeritType');
		$types = $MT->find('all');
		$this->unbindModel(array('hasMany' => array('Merit')));
		$stats = array();
		foreach ($types as $type) {
			$this->_bindMeritType($type);
		}
		$this->recursive = 1;
		$cv = $this->read(null);
		foreach($types as $type) {
			$alias = $type['MeritType']['alias'];
			$stats[$alias] = count($cv[$alias]);
		}
		return $stats;
	}

/**
 * Resumes that are between 11 and 12 months old to send a notification of expiration
 *
 * @param string $id 
 * @return void
 * @author Fran Iglesias
 */
	public function aboutToExpire($id = null)
	{
		$conditions = array(
			"TIMESTAMPDIFF(MONTH,Resume.modified,CURDATE()) BETWEEN ? AND ?" => array(11, 12)
		);
		$aboutToExpire = $this->find('all', compact('conditions'));
		return $aboutToExpire;
	}
	
/**
 * Resumes to expire
 *
 * @param string $id 
 * @return void
 */
	public function expired($id = null)
	{
		$conditions = array(
			"TIMESTAMPDIFF(MONTH,Resume.modified,CURDATE()) >=" => 12
		);
		$expired = $this->find('all', compact('conditions'));
		return $expired;
	}
	
	public function identifier($id = null)
	{
		$this->setId($id);
		$data = $this->read(null);
		$return = array(
			'id' => $this->id,
			'email' => $data['Resume']['email'],
			'firstname' => $data['Resume']['firstname'],
			'lastname' => $data['Resume']['lastname']
		);
	}
	
	protected function _bindMeritType($meritType)
	{
		$keys = array(
			'className' => 'Resumes.Merit',
			'foreignKey' => 'resume_id',
			'conditions' => array('merit_type_id' => $meritType['MeritType']['id'])
		);
		$this->bindModel(array('hasMany' => array($meritType['MeritType']['alias'] => $keys)));
	}
	
	
}
?>