<?php
/**
 * Labelled Model
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
class Labelled extends LabelsAppModel {
	var $name = 'Labelled';
	var $useTable = 'labelled';
	var $belongsTo = array(
		'Label' => array(
			'className' => 'Labels.Label'
		)
	);
		
}
?>