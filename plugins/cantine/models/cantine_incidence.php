<?php
class CantineIncidence extends CantineAppModel {
	var $name = 'CantineIncidence';

	var $belongsTo = array(
		'Student' => array(
			'className' => 'School.Student',
			'foreignKey' => 'student_id',
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
			'uniqueIncidence' => array(
				'rule' => 'uniqueIncidence',
				'on' => 'both'
			),
			'isWeekDay' => array(
				'rule' => 'isWeekDay',
			)
		)
	);

	
	public function  __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['index'] = true;
	}
	
	public function _findIndex($state, $query, $results = array())
	{
		$this->virtualFields['fullname'] = $this->Student->virtualFields['fullname'];
		if ($state === 'before') {
			$query['fields'] = array(
				'CantineIncidence.*', 'Section.title');
			$query['joins'] = array(
				array(
					'table' => 'students',
					'alias' => 'Student',
					'type' => 'LEFT',
					'conditions' => array(
						'CantineIncidence.student_id = Student.id'
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
			$query['order'] = array('CantineIncidence.date' => 'desc');
			return $query;
		}
		unset($this->virtualFields['fullname']);
		return $results;
	}
	
/**
 * The incidence is unique for student_id and date
 *
 * @param string $check 
 * @return void
 */
	public function uniqueIncidence($check)
	{
		return $this->uniqueCantine(array('date' => $this->data['CantineIncidence']['date']));
	}

	
}
?>