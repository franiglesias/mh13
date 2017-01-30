<?php
class Merit extends ResumesAppModel {
	var $name = 'Merit';
	var $displayField = 'title';

	var $belongsTo = array(
		'MeritType' => array(
			'className' => 'MeritType',
			'foreignKey' => 'merit_type_id',
		),
		'Resume' => array(
			'className' => 'Resume',
			'foreignKey' => 'resume_id',
		),
	);
	
	var $actsAs = array(
		'Uploads.Upable' => array(
			'file' => array(
				'move' => 'route',
				'return' => 'link'
			)
		)
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['show'] = true;
	}

	public function _findShow($state, $query, $results = array())
	{
		if ($state === 'before') {
			$extraQuery['conditions'] = array(
				'Merit.merit_type_id' => $query['merit_type_id'],
				'Merit.resume_id' => $query['resume_id']
			);
			$extraQuery['order'] = array(
				'Merit.end' => 'desc',
				'Merit.start' => 'desc'
			);
			$query = Set::merge($query, $extraQuery);
			return $query;
		}
		return $results;
	}
}
?>