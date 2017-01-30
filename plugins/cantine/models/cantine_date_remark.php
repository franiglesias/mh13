<?php
class CantineDateRemark extends CantineAppModel {
	var $name = 'CantineDateRemark';
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['range'] = true;
	}

	public function _findRange($state, $query, $results = array())
	{
		if ($state === 'before') {
			$extraQuery = array(
				'conditions' => array(
					'CantineDateRemark.date BETWEEN ? AND ?'  => array(
						$query['start'],
						$query['end']
					)
				)
			);
			return Set::merge($query, $extraQuery);
		}
		return Set::combine($results, '/CantineDateRemark/date', '/CantineDateRemark/remark');
	}
}


?>