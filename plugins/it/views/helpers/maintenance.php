<?php
/**
 * MaintenanceHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

App::import('Helper', 'SinglePresentationModel');

class MaintenanceHelper extends SinglePresentationModelHelper {
	var $model = 'Maintenance';
	var $source = 'maintenance';
	var $helpers = array('Html', 'Form', 'Ui.XHtml');
	var $statuses = array();
	
	protected $transitions = array(
		Maintenance::OPEN => array(
			array('action' => 'send', 'label' => 'SAT', 'class' => 'mh-btn-care'),
			array('action' => 'repair', 'label' => 'Repair', 'class' => 'mh-btn-care')
		),
		Maintenance::SAT => array(
			array('action' => 'restore', 'label' => 'Restore', 'class' => 'mh-btn-ok'),
			array('action' => 'retire', 'label' => 'Retire', 'class' => 'mh-btn-cancel'),
		),
		Maintenance::INTERNAL => array(
			array('action' => 'restore', 'label' => 'Restore', 'class' => 'mh-btn-ok'),
			array('action' => 'retire', 'label' => 'Retire', 'class' => 'mh-btn-cancel'),
		),
		Maintenance::RESOLVED => array(
			array('action' => 'reopen', 'label' => 'Reopen', 'class' => 'mh-btn-view')
		),
		Maintenance::UNRESOLVED => array(
			array('action' => 'reopen', 'label' => 'Reopen', 'class' => 'mh-btn-view')
		),
	);
	
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->definitions();
	}
	
	public function definitions()
	{
		$this->statuses = array(
			Maintenance::OPEN => __d('it', 'Open', true),
			Maintenance::SAT => __d('it', 'Sent to SAT', true),
			Maintenance::INTERNAL => __d('it', 'Repair in house', true),
			Maintenance::RESOLVED => __d('it', 'Resolved', true),
			Maintenance::UNRESOLVED => __d('it', 'Unresolved', true),
		);
	}
	
	
	public function transitions($class)
	{
		$data = $this->transitions[$this->value('status')];
		$code = '';
		foreach ($data as $button) {
			$code .= $this->transitionButton($button['action'], $button['label'], $button['class']);
		}
		$code = $this->XHtml->ajaxLoading('maintenance-transitions').$code;
		return $this->Html->div($class, $code);
	}
	
	public function transitionButton($transition, $label, $class = 'mh-btn-care')
	{
		return $this->Html->link(
			$label,
			array('action' => $transition, $this->value('id')),
			array(
				'class' => 'mh-ajax-button '.$class,
				'mh-indicator' => '#maintenance-transitions',
				'mh-update' => '#maintenance-form',
			)
		);
	}
	
}