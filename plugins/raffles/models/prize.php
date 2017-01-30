<?php
class Prize extends RafflesAppModel {
	var $name = 'Prize';
	var $displayField = 'title';
	var $order = array('Prize.number' => 'asc');
	
	public function getSponsors()
	{
		return Set::extract(
			$this->find('all', array('fields' => array('DISTINCT(sponsor)'))), 
			'/Prize/sponsor'
		);
	}
	
	public function findAll()
	{
		return $this->find('all', array(
				'conditions' => array('Prize.number !=' => null),
				'order' => array('Prize.number' => 'asc')
				)
			);
	}
}
?>