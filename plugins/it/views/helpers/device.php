<?php
/**
 * DeviceHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

App::import('Helper', 'SinglePresentationModel');
App::import('Model', 'It.Device');

class DeviceHelper extends SinglePresentationModelHelper {

	var $helpers = array('Html', 'Form');
	var $source = 'device';
	var $model = 'Device';
	
	var $statuses;
	var $shortStatuses;
	var $colorStatuses;
	/**
	 * Called after the controller action is run, but before the view is rendered.
	 *
	 * @access public
	 */
	function __construct($options = array()) {
		parent::__construct($options);
		$this->statuses = array(
			Device::ACTIVE => __d('it', 'Active', true),
			Device::SAT => __d('it', 'SAT', true),
			Device::INTERNAL => __d('it', 'Retired for Maintenance', true),
			Device::RETIRED => __d('it', 'Removed', true)
		);
		$this->shortStatuses = array(
			Device::ACTIVE => __d('it', 'A', true),
			Device::SAT => __d('it', 'S', true),
			Device::INTERNAL => __d('it', 'R', true),
			Device::RETIRED => __d('it', 'X', true)
		);
		
		$this->colorStatuses = array(
			Device::ACTIVE => 'allowed',
			Device::SAT => 'limited',
			Device::INTERNAL => 'limited',
			Device::RETIRED => 'forbidden'
		);
		
	}
	
	public function jsonRepopulateForm()
	{
		$data = array(
			'DeviceStatus' => $this->value('status'),
			'DeviceStatusLabel' => $this->statuses[$this->value('status')],
			'DeviceStatusRemark' => $this->value('status_remark')
		);
		return json_encode($data);
	}
	
	public function dashboard()
	{
		$statusClass = 'mh-'.$this->colorStatuses[$this->value('status')];
		$device = $this->format('title', 'string', '<strong>%s</strong><br />');
		$remark = $this->value('status_remark');
		return $this->format($device.$remark, 'string', '<p class="'.$statusClass.'">%s</p>');
	}

}