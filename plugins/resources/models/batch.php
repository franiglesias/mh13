<?php
class Batch extends ResourcesAppModel {
	var $name = 'Batch';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'Access.User',
			'foreignKey' => 'user_id',
		),
		'Subject' => array(
			'className' => 'School.Subject',
			'foreignKey' => 'subject_id'
		),
		'Level' => array(
			'className' => 'School.Level',
			'foreignKey' => 'level_id'
		)
	);

	var $hasMany = array(
		'Resource' => array(
			'className' => 'Resources.Resource',
			'foreignKey' => 'batch_id',
			'dependent' => false,
		)
	);

	var $actsAs = array(
		'Tags.Taggable',
		'Uploads.Attachable'
	);
	
	public function afterSave($created)
	{
		$files = $this->Attachment->find('all', array(
			'conditions' => array('model' => $this->alias, 'foreign_key' => $this->id)
		));
		if (!$files) {
			return;
		}
		$counter = 0;
		App::import('Lib', 'FiMime');
		$FM = ClassRegistry::init('FiMime');
		foreach ($files as $file) {
			$type = $FM->simpleType($file['Attachment']['path']);
			if ($type == 'image') {
				$counter++;
				$title = sprintf('%s-%03d', $this->data['Batch']['title'], $counter);
			} else {
				$title = $file['Attachment']['name'];
			}
			$resource = array(
				'Resource' => array(
					'batch_id' => $this->id,
					'title' => $title,
					'description' => $this->data['Batch']['description'],
					'tags' => $this->data['Batch']['tags'],
					'user_id' => $this->data['Batch']['user_id'],
					'level_id' => $this->data['Batch']['level_id'],
					'subject_id' => $this->data['Batch']['subject_id']
				)
			);
			
			$this->Resource->create();
			$this->Resource->save($resource);
			// $rid = $this->Resource->getLastInsertId();
			$this->Attachment->setId($file['Attachment']['id']);
			$this->Attachment->attach($this->Resource);
			$this->Resource->addVersion($rid, $file['Attachment']['id'], __d('resources', 'First version', true));
		}
		
	}
}
