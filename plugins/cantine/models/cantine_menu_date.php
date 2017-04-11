<?php

App::import('Model', 'Cantine.CantineDateRemark');

class CantineMenuDate extends CantineAppModel {
	var $name = 'CantineMenuDate';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'CantineWeekMenu' => array(
			'className' => 'Cantine.CantineWeekMenu',
			'foreignKey' => 'cantine_week_menu_id',
		)
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['today'] = true;
		$this->_findMethods['thisweek'] = true;
		$this->_findMethods['thismonth'] = true;
		$this->_findMethods['range'] = true;
	}
	
/**
 * $query
 *		'today': a day in the week
 *
 * @param string $state
 * @param string $query
 * @param string $results
 *
 * @return void
 * @author Fran Iglesias
 */
	public function _findThisweek($state, $query, $results = array())
	{
		if ($state === 'before') {
			$today = $this->setToday($query);
			$query['start'] = strtotime('last monday', $today);
			$query['end'] = strtotime('+ 4 day', $query['start']);
			return $this->_findRange('before', $query);
		}
		return $this->_findRange($state, $query, $results);
	}

	private function setToday($query)
	{
		if (empty($query['today'])) {
			return time();
		}
		return strtotime($query['today']);
	}

	public function _findRange($state, $query, $results = array())
	{
		if ($state === 'before') {
			if (empty($query['start'])) {
				$query['start'] = time();
			}
			if (empty($query['end'])) {
				$query['end'] = strtotime("+1 week");
			}
			$query['start'] = date('Y-m-d', $query['start']);
			$query['end'] = date('Y-m-d', $query['end']);

			$extraQuery = array(
				'conditions' => array(
					"CantineMenuDate.start + INTERVAL 4 DAY >= '{$query['start']}'",
					"CantineMenuDate.start <=" => $query['end']
					),
				'contain' => array(
					'CantineWeekMenu' => array(
						'CantineDayMenu'
						)
					),
				'order' => array(
					'CantineMenuDate.start' => 'asc'
				)
			);
			return Set::merge($query, $extraQuery);
		}
		$remarks = ClassRegistry::init('CantineDateRemark')->find('range', array('start' => $query['start'], 'end' => $query['end']));
		if (!empty($remarks)) {
			$results['Remark'] = $remarks;
		}
		return $results;
	}

    public function _findThismonth($state, $query, $results = array())
    {
        if ($state === 'before') {
            $today = $this->setToday($query);
            $query['start'] = strtotime(date('Y-m-01', $today));
            $query['end'] = strtotime(date('Y-m-t', $today));

            return $this->_findRange('before', $query);
        }

        return $this->_findRange($state, $query, $results);
    }

    public function _findToday($state, $query, $results = array())
    {
        if ($state === 'before') {
            $today = $this->setToday($query);
            $query['start'] = $query['end'] = $today;

            return $this->_findRange('before', $query);
        }

        return $this->_findRange($state, $query, $results);
    }
	
	
}
?>
