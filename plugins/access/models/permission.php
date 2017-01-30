<?php

App::import('Model', 'Access.PermissionsRole');

class Permission extends AccessAppModel {
	var $name = 'Permission';
	
	var $displayField = 'description';

	public function getAutocomplete($term)
	{
		$result = $this->find('all', array(
			'fields' => array('id', 'description'),
			'conditions' => array('description LIKE ' => '%'.$term.'%'),
			'order' => array('description' => 'asc')
		));
		if (!$result) {
			return false;
		}
		$compact = array();
		foreach ($result as $value) {
			$compact[] = array(
				'label' => $value['Permission']['description'],
				'value' => $value['Permission']['id']
			);
		}
		return $compact;
	}
	
	public function add($pattern, $description)
	{
		$this->create();
		$this->set(array(
			'url_pattern' => $pattern,
			'description' => $description
		));
		$this->save();
		$this->data = $this->read(null);
	}
	
	public function getByPattern($pattern)
	{
		$this->data = $this->find('first', array(
			'conditions' => array('url_pattern' => $pattern)
		));
		if ($this->data) {
			$this->id = $this->data['Permission']['id'];
		} else {
			$this->id = false;
		}
	}
	
	public function defined($pattern)
	{
		$count = $this->find('count', array(
			'conditions' => array('url_pattern' => $pattern)
		));
		return ($count > 0);
	}
	
	public function flush()
	{
		ClassRegistry::init('PermissionsRole')->flushPermission($this);
	}
}
?>