<?php
class CantineRegular extends CantineAppModel {
	var $name = 'CantineRegular';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Student' => array(
			'className' => 'School.Student',
			'foreignKey' => 'student_id',
		)
	);
	
	var $actsAs = array(
		'Ui.Binary' => array(
			'days_of_week'
		),
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
		'month' => array(
			'uniqueRegular' => array(
				'rule' => 'uniqueRegular',
				'last' => true,
				'on' => 'both',
				),
			'emptyMonth' => array(
				'rule' => 'notEmpty',
				'on' => 'create'
			)
		)
	);
	
	public function  __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['index'] = true;
		$this->virtualFields = array(
			'total_days' => "LENGTH(REPLACE(conv(days_of_week,10,2), '0', ''))",
		);
		
	}
	
	public function afterDuplicate()
	{
		$this->moveRegularToNextCalendarMonth();
	}
	
	private function moveRegularToNextCalendarMonth()
	{
		if ($this->data['CantineRegular']['month'] < 12) {
			$this->data['CantineRegular']['month']++;
		} else {
			$this->data['CantineRegular']['month'] = 1;
		}
	}

/**
 * Validation rule
 *
 * Valid if there is not another record with the same month and student
 *
 * @param array $check 
 * @return boolean
 */
	public function uniqueRegular($check)
	{
		return $this->uniqueCantine(array('month' => $check['month']));
	}


/**
 * Find the records for index admin
 *
 * @param string $state 
 * @param string $query 
 * @param string $results 
 * @return void
 * @author Fran Iglesias
 */
	public function _findIndex($state, $query, $results = array())
	{
		$this->virtualFields['fullname'] = $this->Student->virtualFields['fullname'];
		if ($state === 'before') {
			$query['fields'] = array(
				'CantineRegular.*','Section.title',
			);
			$query['joins'] = array(
				array(
					'table' => 'students',
					'alias' => 'Student',
					'type' => 'LEFT',
					'conditions' => array(
						'CantineRegular.student_id = Student.id'
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
	

/**
 * Copy cantine regulars to a new month
 *
 * @param integer $month current month
 * @return boolean
 * @author Frankie
 */	
	public function copyToNewMonth($month) {

		switch ($month) {
			case 12:
				$newMonth = 1;
				break;
			case 6:
				$newMonth = 9;
				break;
			default:
				$newMonth = $month + 1;
				break;
		}
		$newMonth  = $month == 12 ? 1 : ($month == 6 ? 9 : $month + 1);
		$query = 'INSERT INTO cantine_regulars (student_id, days_of_week, month) SELECT student_id, days_of_week, '. $newMonth.' from cantine_regulars where month = '.$month;
		$this->query($query);
		return true;
	}
}
?>