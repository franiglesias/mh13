<?php
class Student extends SchoolAppModel {
	var $name = 'Student';

	var $belongsTo = array(
		'Section' => array(
			'className' => 'School.Section',
			'foreignKey' => 'section_id',
		)
	);
	
	var $hasMany = array(
		'CantineRegular' => array(
			'className' => 'Cantine.CantineRegular',
			'foreignKey' => 'student_id'
		),
		'CantineIncidence' => array(
			'className' => 'Cantine.CantineIncidence',
			'foreignKey' => 'student_id'
		),
		'CantineTicket' => array(
			'className' => 'Cantine.CantineTicket',
			'foreignKey' => 'student_id'
		),
		
	);
	
	var $displayField = 'fullname';
	
	var $actsAs = array(
		'Ui.Binary' => array('extra1')
	);

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['cantine'] = true;
		$this->_findMethods['cantineStats'] = true;
		$this->_findMethods['cantineStats2'] = true;
		$this->_findMethods['section'] = true;
		$this->virtualFields = array(
			'fullname' => "CONCAT(`{$this->alias}`.`lastname1`,' ',`{$this->alias}`.`lastname2`, ', ', `{$this->alias}`.`firstname`)",
			'name'=>"CONCAT_WS(' ', `{$this->alias}`.`firstname`,`{$this->alias}`.`lastname1`, `{$this->alias}`.`lastname2`)"
		);
	}



/**
 * Retrieve data for autocomplete action
 *
 * @param string $term
 *
 * @return void
 */
	public function autocomplete($term)
	{
		if (!$term) {
			return false;
		}
		return $this->find('list', array(
			'fields' => array('id', 'fullname'), 
			'conditions' => array('fullname LIKE' => $term.'%' ),
			'order' => array('fullname' => 'asc')
			)
		);
	}

    public function _findCantineStats($state, $query, $results = array())
    {
        if ($state === 'before') {
            $query = $this->_findCantine('before', $query);
            $query['fields'] = array(
                'CantineTurn.title',
                'count(Student.id) AS total',
            );
            $query['group'] = array('CantineTurn.slot');

            return $query;
        }
        foreach ($results as &$result) {
            $result['CantineTurn']['attendances'] = $result[0]['total'];
            unset($result[0]);
        }

        return $results;
    }
	
	public function _findCantine($state, $query, $results = array())
	{
		if ($state === 'before') {

			if (!$query['date']) {
				$query['date'] = date('Y-m-d');
			}

			$date = $query['date'];

			$thisMonth = date('m', strtotime($date));
			$thisWeekDay = pow(2, date('w', strtotime($date)) - 1);

			$fields = array('Student.id','Student.fullname', 'Section.title', 'Student.remarks','CantineTurn.title', 'CantineIncidence.remark');
			$joins = array(
				array(
					'table' => 'cantine_incidences',
					'alias' => 'CantineIncidence',
					'type' => 'LEFT',
					'conditions' => array(
						'Student.id = CantineIncidence.student_id',
						'CantineIncidence.date' => $date
					)
				),
				array(
					'table' => 'cantine_regulars',
					'alias' => 'CantineRegular',
					'type' => 'LEFT',
					'conditions' => array(
						'Student.id = CantineRegular.student_id',
						'CantineRegular.month' => $thisMonth
					)
				),
				array(
					'table' => 'cantine_tickets',
					'alias' => 'CantineTicket',
					'type' => 'LEFT',
					'conditions' => array(
						'Student.id = CantineTicket.student_id',
						'CantineTicket.date' => $date
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
				array(
					'table' => 'cantine_groups',
					'alias' => 'CantineGroup',
					'type' => 'LEFT',
					'conditions' => array(
						'Section.cantine_group_id = CantineGroup.id'
					)
				),
				array(
					'table' => 'cantine_rules',
					'alias' => 'CantineRule',
					'type' => 'LEFT',
					'conditions' => array(
						'CantineGroup.id = CantineRule.cantine_grou`p_id'
					)
				),
				array(
					'table' => 'cantine_turns',
					'alias' => 'CantineTurn',
					'type' => 'LEFT',
					'conditions' => array(
						'CantineRule.cantine_turn_id = CantineTurn.id'
					)
				),
			);

			$conditions = array(
				"CantineRule.day_of_week & $thisWeekDay",
				array('or' => array(
					array(
                        'CantineRegular.month' => $thisMonth,
                        "CantineRegular.days_of_week & $thisWeekDay",
						'CantineTicket.date' => null
						),
					array(
                        'CantineTicket.date' => $date,
						'or' => array(
							'CantineRegular.month' => null,
							array(
                                'CantineRegular.month' => $thisMonth,
								'not' => array("CantineRegular.days_of_week & $thisWeekDay")
								)
							)
						)
				)),
				"IF(CantineRule.extra1 = 2, Student.extra1 & $thisWeekDay, if(CantineRule.extra1 = 1, NOT(Student.extra1 & $thisWeekDay), true))",
				"IF(CantineRule.extra2 = 2, Student.extra2 = 1, if(CantineRule.extra2 = 1, Student.extra2 = 0, true))"
			);

			$order = array(
				'CantineTurn.slot' => 'asc',
				'Student.section_id' => 'asc',
				'Student.fullname' => 'asc'
			);

			$query = Set::merge($query, compact('fields', 'conditions', 'joins', 'order'));

            return $query;
		}
		foreach ($results as &$result) {
			if (!empty($result['CantineIncidence']['remark'])) {
				$result['Student']['remarks'] = __d('cantine', '>>> ', true).
					$result['CantineIncidence']['remark'].'<br />'.
					$result['Student']['remarks'];
			}

        }
		return $results;
	}
	
	public function _findCantineStats2($state, $query, $results = array())
	{
		if ($state === 'before') {
			$query = $this->_findCantine('before', $query);
			$query['fields'] = array(
				'CantineTurn.title', 
				'CantineTurn.slot',
				'count(Student.id) AS total',
				'Stage.abbr',
				'Stage.id'
			);
			$query['joins'][] = array(
				'table' => 'stages',
				'alias' => 'Stage',
				'type' => 'LEFT',
				'conditions' => array(
					'Section.stage_id = Stage.id'
				)
			);
			$query['group'] = array('CantineTurn.slot', 'Section.stage_id');
			$query['order'] = array(
				'CantineTurn.slot' => 'asc',
				'Stage.id' => 'asc',
			);
			return $query;
		}
		$stages = $this->Section->Stage->find('all');
		$final = array();
		foreach ($results as $result) {
			$slot = $result['CantineTurn']['slot']; 
			if (!isset($final[$slot]['CantineTurn']['attendances'])) {
				$final[$slot]['CantineTurn']['attendances'] = 0;
			}
			foreach ($stages as $stage) {
				$index = strtolower($stage['Stage']['abbr']);
				$final[$slot]['CantineTurn']['title'] = $result['CantineTurn']['title'];
				if (!isset($final[$slot]['CantineTurn'][$index])) {
					$final[$slot]['CantineTurn'][$index] = 0;
				}
				if ($result['Stage']['id'] === $stage['Stage']['id']) {
					$final[$slot]['CantineTurn'][$index] = $result[0]['total'];
					$final[$slot]['CantineTurn']['attendances'] += $result[0]['total'];
				}
			}
		}
		return $final;
	}
/**
 * Returns the list of students from a section
 *
 * @param string $state
 * @param string $query
 * @param string $results
 *
 * @return void
 * @author Fran Iglesias
 */
	public function _findSection($state, $query, $results = array()) {
		if ($state === 'before') {
			if (isset($query[0])) {
				$query['section'] = $query[0];
			}
			if (isset($query['section'])) {
				$conditions = array('Student.section_id' => $query['section']);
			}
			$contain = array('CantineRegular' => array(
				'conditions' => array('CantineRegular.month' => date('n')),
				'limit' => 1
			));
			$order = array('Student.lastname1' => 'asc', 'Student.lastname2' => 'asc', 'Student.name' => 'asc');
			$extraQuery = compact('conditions', 'contain', 'order');
			$query = Set::merge($query, $extraQuery);
			return $query;
		}
		foreach ($results as &$result) {
			if (isset($result['CantineRegular'][0])) {
			 	$result['CantineRegular'] = $result['CantineRegular'][0];
			} else {
				$result['CantineRegular']['days_of_week'] = 0;
			}
		}
		return $results;
	}
	
	
}
?>
