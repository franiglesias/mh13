<?php
class Planet extends AggregatorAppModel {
	var $name = 'Planet';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $actsAs = array('Ui.Sluggable' => array('fields' => 'title'));
	
	var $hasMany = array(
		'Feed' => array(
			'className' => 'Aggregator.Feed',
			'foreignKey' => 'planet_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>