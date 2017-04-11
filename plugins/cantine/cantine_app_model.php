<?php

class CantineAppModel extends AppModel {
	
# Common validation methods	

/**
 * Validation rule
 * 
 * Valid if a student_id field is set (via autocomplete field)
 *
 * @param array $check 
 * @return boolean
 */
	public function validStudent($check)
	{
		return !empty($this->data[$this->alias]['student_id']);
	}
	
/**
 * Date is a week day
 *
 * @param string $check
 *
 * @return void
 */
	public function isWeekDay($check)
	{
		$weekDay = date('w', strtotime($this->data[$this->alias]['date']));
		return !in_array($weekDay, array(0,6));
	}

/**
 * Common part for uniqueXXX validation
 *
 * @param array date or month condition
 * @return boolean
 * @author Fran Iglesias
 */
	public function uniqueCantine($conditions)
	{
		$conditions['student_id'] = $this->data[$this->alias]['student_id'];
		if (!empty($this->data[$this->alias]['id'])) {
			$conditions['id !='] = $this->data[$this->alias]['id'];
		}
		return !$this->find('count', compact('conditions'));
	}
	
	

}

?>
