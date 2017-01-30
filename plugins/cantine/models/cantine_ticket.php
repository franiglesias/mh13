<?php
class CantineTicket extends CantineAppModel {
	var $name = 'CantineTicket';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Student' => array(
			'className' => 'School.Student',
			'foreignKey' => 'student_id'
		)
	);
	
	var $actsAs = array(
		'Ui.Duplicable' => array(
			'cascade' => true,
			'callbacks' => true
		)
	);

	var $validate = array(
		'student_id' => array('notEmpty'),
		'student_id-complete' => array(
			'validStudent' => array(
				'rule' => 'validStudent',
				'last' => true
				),
			'emptyStudent' => array(
				'rule' => 'notEmpty'
			)
		),
		'date-alt' => array(
			'uniqueTicket' => array(
				'rule' => 'uniqueTicket',
				'on' => 'both'
			),
			'weekDay' => array(
				'rule' => 'isWeekDay',
			)
		)
	);

	public function  __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['index'] = true;
	}


/**
 * Manages After duplicate changes to the record. Suggest a new date avoiding weekends
 *
 * @return void
 */
	public function afterDuplicate()
	{
		$date = strtotime($this->data['CantineTicket']['date']);
		$date += $this->isFriday($date) ? 3 * DAY : DAY;
		$this->data['CantineTicket']['date'] = date('Y-m-d', $date);
	}
	
	private function isFriday($date)
	{
		return date('w', $date) == 5;
	}
	
/**
 * The ticket is unique for student_id and date
 *
 * @param string $check 
 * @return void
 */
	public function uniqueTicket($check)
	{
		return $this->uniqueCantine(array('date' => $this->data['CantineTicket']['date']));
	}

	public function _findIndex($state, $query, $results = array())
	{
		$this->virtualFields['fullname'] = $this->Student->virtualFields['fullname'];
		
		if ($state === 'before') {
			$query['fields'] = array(
				'CantineTicket.*','Section.title'
			);
			$query['joins'] = array(
				array(
					'table' => 'students',
					'alias' => 'Student',
					'type' => 'LEFT',
					'conditions' => array(
						'CantineTicket.student_id = Student.id'
					)
				),
				array(
					'table' => 'sections',
					'alias' => 'Section',
					'type' => 'LEFT',
					'conditions' => array(
						'Student.section_id = Section.id'
					)
				),
				
			);
			$query['order'] = array(
				'Student.section_id' => 'asc',
				'Student.lastname1' => 'asc',
				'Student.lastname2' => 'asc',
				'Student.firstname' => 'asc'
			);
			return $query;
		}
		
		unset($this->virtualFields['fullname']);
		return $results;
	}

	
}
?>