<?php
class Device extends ItAppModel {
	var $name = 'Device';
	var $displayField = 'title';

	const ACTIVE = 0;
	const SAT = 1;
	const INTERNAL = 2;
	const RETIRED = 3;
	
	var $belongsTo = array(
		'DeviceType' => array(
			'className' => 'It.DeviceType',
			'foreignKey' => 'device_type_id',
		)
	);

	var $hasMany = array(
		'Maintenance' => array(
			'className' => 'It.Maintenance',
			'foreignKey' => 'device_id',
			'dependent' => false,
		)
	);
	
	var $actsAs = array(
		'Uploads.Upable' => array(
			'image' => array(
				'move' => 'route',
				'return' => 'link'
				)
			),
		'Ui.Duplicable'
	);
	
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['maintenance'] = true;
	}

	public function countOpenedMaintenances($id = null)
	{
		$this->setId($id);
		return $this->Maintenance->find('count', array(
			'conditions' => array(
				'Maintenance.device_id' => $id,
				'Maintenance.status' => array(
					Maintenance::OPEN,
					Maintenance::SAT,
					Maintenance::INTERNAL
				)
			)
		));
	}
	
	public function updateRemarks($update, $id = null)
	{
		$this->setId($id);
		$this->saveField('status_remark', $update);
	}
	
	public function repair($id = null)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Device::INTERNAL,
			'status_remark' => __d('it', 'Will be repaired in house', true)
		));
		$this->save();
	}
	
	public function send($id = null)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Device::SAT,
			'status_remark' => __d('it', 'Sent to an external SAT', true)
		));
		$this->save();	
	}
	
	public function restore($id = null)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Device::ACTIVE,
			'status_remark' => __d('it', 'This device is working', true)
		));
		$this->save();	
	}

	public function retire($id = null)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Device::RETIRED,
			'status_remark' => __d('it', 'Retired. This device is no longer in use', true)
		));
		$this->save();	
	}

	public function open($id = null)
	{
		$this->setId($id);
		$this->set(array(
			'status' => Device::ACTIVE,
			'status_remark' => __d('it', 'A maintenance action has been set for this Device', true)
		));
		$this->save();	
	}


	public function afterDuplicate()
	{
		$this->set(array(
			'mac' => '',
			'serial' => '',
			'remarks' => '',
			'status' => Device::ACTIVE,
			'status_remark' => ''
		));
	}
	
	public function _findMaintenance($state, $query, $results = array())
	{
		if ($state === 'before') {
			$extraQuery = array(
				'conditions' => array(
					'Device.status' => array(Device::SAT, Device::INTERNAL)
				),
				'order' => array(
					'Device.title' => 'asc'
				)
			);
			$query = Set::merge($query, $extraQuery);
			return $query;
		}
		return $results;
	}
}
?>