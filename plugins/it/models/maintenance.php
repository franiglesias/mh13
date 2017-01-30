<?php

class Maintenance extends ItAppModel {
	var $name = 'Maintenance';

	const OPEN = 0;
	const SAT = 1;
	const INTERNAL = 2;
	const RESOLVED = 3;
	const UNRESOLVED = 4;

	var $belongsTo = array(
		'Device' => array(
			'className' => 'It.Device',
			'foreignKey' => 'device_id',
		),
		'Technician' => array(
			'className' => 'It.Technician',
			'foreignKey' => 'technician_id'
		),
		'MaintenanceType' => array(
			'className' => 'It.MaintenanceType',
			'foreignKey' => 'maintenance_type_id'
		)
	);
	
	var $virtualFields = array(
		'days' => 'DATEDIFF(Maintenance.resolved, Maintenance.detected)',
		'response' => 'DATEDIFF(Maintenance.resolved, Maintenance.requested)',
		'delay' => 'DATEDIFF(Maintenance.requested, Maintenance.detected)'
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['response'] = true;
		$this->_findMethods['index'] = true;
	}
	
	/**
	 * Adds a line in the remarks field, like a per record log facility
	 * This could be a Behavior
	 *
	 * @param string $line 
	 * @param string $id 
	 * @return void
	 * @author Fran Iglesias
	 */
	
	public function addHistory($line, $id = null)
	{
		$this->setId($id);
		$remarks = $this->field('remarks');
		$line = sprintf('%s: %s', date('Y-m-d'), $line);
		$remarks .= (strlen($remarks) ? chr(10) : '').$line;
		$this->saveField('remarks', $remarks);
	}
	
	
	public function beforeSave($created)
	{
		if (empty($this->data['Maintenance']['resolved'])) {
			unset($this->data['Maintenance']['resolved']);
		}
		return true;
	}
	public function _findIndex($state, $query, $results = array())
	{
		if ($state === 'before') {
			$contain = array('Device' => array('fields' => array('id', 'title')));
			$fields = array('id', 'created', 'description', 'device_id', 'status', 'requested', 'resolved', 'technician_id', 'maintenance_type_id','response', 'delay', 'days');
			$order = array('device_id' => 'asc', 'requested' => 'desc');
			$query = Set::merge($query, compact('contain', 'fields', 'order'));
			return $query;
		}
		return $results;
	}
	
	public function _findResponse($state, $query, $results = array())
	{
		if ($state === 'before') {
			$rQuery = array(
				'fields' => array(
					'DeviceType.id',
					'DeviceType.title',
					'MaintenanceType.id',
					'MaintenanceType.title',
					'Technician.id',
					'Technician.title',
					'AVG(DATEDIFF(Maintenance.resolved, Maintenance.requested)) AS response_time',
					'MIN(DATEDIFF(Maintenance.resolved, Maintenance.requested)) AS min_response_time',
					'MAX(DATEDIFF(Maintenance.resolved, Maintenance.requested)) AS max_response_time',
					'AVG(DATEDIFF(Maintenance.resolved, Maintenance.detected)) AS total_time',
					'MIN(DATEDIFF(Maintenance.resolved, Maintenance.detected)) AS min_total_time',
					'MAX(DATEDIFF(Maintenance.resolved, Maintenance.detected)) AS max_total_time',
					'COUNT(*) AS actions'
				),
				'joins' => array(
					array(
						'table' => 'devices',
						'alias' => 'Device',
						'type' => 'left',
						'conditions' => array(
							'Device.id = Maintenance.device_id'
						)
					),
					array(
						'table' => 'device_types',
						'alias' => 'DeviceType',
						'type' => 'left',
						'conditions' => array(
							'DeviceType.id = Device.device_type_id'
						)
					),
					array(
						'table' => 'maintenance_types',
						'alias' => 'MaintenanceType',
						'type' => 'left',
						'conditions' => array(
							'MaintenanceType.id = Maintenance.maintenance_type_id'
						)
					),
					array(
						'table' => 'technicians',
						'alias' => 'Technician',
						'type' => 'left',
						'conditions' => array(
							'Technician.id = Maintenance.technician_id'
						)
					)
				),
				'group' => array(
					'DeviceType.id',
					'MaintenanceType.id',
					'Technician.id with rollup'
				)
 			);
			
			$query = array_merge($query, $rQuery);
			return $query;
		}
		foreach ($results as &$result) {
			$result['Maintenance'] = $result[0];
			if (empty($result['MaintenanceType']['id'])) {
				$result['DeviceType']['title'] = '>>> '.sprintf(__d('it', 'Total %s', true), $result['DeviceType']['title']);
				$result['MaintenanceType']['title'] = '---';
			}
			if (empty($result['DeviceType']['id'])) {
				$result['DeviceType']['title'] = '---';
			}
			if (empty($result['Technician']['id'])) {
				if (!empty($result['MaintenanceType']['id'])) {
					$result['MaintenanceType']['title'] = '>>> '.sprintf(__d('it', 'Total %s', true), $result['MaintenanceType']['title']);
				}
				$result['Technician']['title'] = '---';
			}
			unset($result[0]);
		}
		return $results;
	}
	
}
?>