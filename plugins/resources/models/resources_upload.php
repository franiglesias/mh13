<?php
class ResourcesUpload extends ResourcesAppModel {
	var $name = 'ResourcesUpload';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Resource' => array(
			'className' => 'Resources.Resource',
			'foreignKey' => 'resource_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Upload' => array(
			'className' => 'Resources.Upload',
			'foreignKey' => 'upload_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>