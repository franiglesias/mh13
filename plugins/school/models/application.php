<?php
class Application extends SchoolAppModel {
	const RECEIVED = 0;
	const OPENED = 1;
	const INTERVIEWED = 2;
	const ACCEPTED = 3;
	const CLOSED = 4;
	const PENDING = 0;
	const REJECTED = 1;
	const NOT_CONFIRMED = 2;
	const CONFIRMED = 4;
    var $name = 'Application';
    // const ACCEPTED = 3
    var $displayField = 'student';
	var $virtualFields = array(
		'student' => "CONCAT_WS(', ',Application.last_name, Application.first_name)"
	);
	
	var $belongsTo = array(
		'Level' => array(
			'className' => 'School.Level',
			'foreignKey' => 'level_id',
		),
	);
	
	var $validate = array(
		'first_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		), 
		'last_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		), 
		'parent' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'idcard' => array(
			'atLeastOne' => array(
				'rule' => array('atLeastOneId'),
				'message' => 'At least one identifier'
			),
			'isDni' => array(
				'rule' => array('idcard'),
				'allowEmpty' => true,
				'message' => 'This is nor a valid spanish NIF'
			),
			'isUnique' => array(
				'rule' => 'isUnique'
			)
		),
		'father_idcard' => array(
			'atLeastOne' => array(
				'rule' => array('atLeastOneId'),
				'message' => 'At least one identifier'
			),
			// 'isDni' => array(
			// 	'rule' => array('idcard'),
			// 	'allowEmpty' => true,
			// 	'message' => 'This is not a valid spanish NIF'
			// ),
		),
		'mother_idcard' => array(
			'atLeastOne' => array(
				'rule' => array('atLeastOneId'),
				'message' => 'At least one identifier'
			),
			// 'isDni' => array(
			// 	'rule' => array('idcard'),
			// 	'allowEmpty' => true,
			// 	'message' => 'This is not a valid spanish NIF'
			// ),
		),
		'phone' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'email' => array(
			'email' => array(
				'rule' => 'email'
			)
		)
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}
	
/**
 * validation. There must be at least one valid idcard to store the application
 *
 * @param string $value
 *
 * @return boolean
 */
	public function atLeastOneId($value) {
		if (empty($this->data['Application']['idcard']) && empty($this->data['Application']['father_idcard']) && empty($this->data['Application']['mother_idcard'])) {
			return false;
		}
		return true;
	}

/**
 * validation. Valid Spanish idcard (NIF/DNI)
 *
 * @param string $value
 *
 * @return void
 * @author Fran Iglesias
 */	
	public function idcard($value) {
		App::import('vendor', 'dni');
		$dni = new Dni();
		$check = array_pop($value);
		return $dni->validateNif($check);
	}
	
	public function get($id, $private = false) {
		$conditions = array(
			'or' => array(
				'idcard' => $id,
				'father_idcard' => $id,
				'mother_idcard' => $id
			)
		);

		$joins = array(
			array(
				'table' => 'levels',
				'alias' => 'Level',
				'type' => 'left',
				'conditions' => array(
					'Application.level_id = Level.id'
				)
			)
		);
		
		if ($private) {
			$conditions['Level.private'] = true;
		} else {
			$conditions['Level.private'] = false;
		}
		
		$result = $this->find('all', compact('joins', 'conditions'));
		return $result;
	}
	
	public function received($id)
	{
		$this->id = $id;
		ClassRegistry::getObject('EventManager')->notify($this, 'school.application.new');
	}
	
	# Transition methods block
	
	public function open($id)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Application::OPENED
		));
		$this->save();
	}
	
	public function interview($id)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Application::INTERVIEWED
		));
		$this->save();
	}
	
	public function accept($id)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Application::ACCEPTED,
			'resolution' => Application::ACCEPTED
		));
		$this->save();
	}

	public function reject($id)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Application::CLOSED,
			'resolution' => Application::REJECTED
		));
		$this->save();
	}

	public function confirm($id)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Application::CLOSED,
			'resolution' => Application::CONFIRMED
		));
		$this->save();
	}
	
	public function noConfirm($id)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Application::CLOSED,
			'resolution' => Application::NOT_CONFIRMED
		));
		$this->save();
	}

	
	# End of Transition methods block
}
?>
