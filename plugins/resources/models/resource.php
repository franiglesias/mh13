<?php
class Resource extends ResourcesAppModel {
	var $name = 'Resource';

	var $belongsTo = array(
		'User' => array(
			'className' => 'Access.User',
			'foreignKey' => 'user_id',
		),
		'Batch' => array(
			'className' => 'Resources.Batch',
			'foreignKey' => 'batch_id',
		),
		'Subject' => array(
			'className' => 'School.Subject',
			'foreignKey' => 'subject_id'
		),
		'Level' => array(
			'className' => 'School.Level',
			'foreignKey' => 'level_id'
		),
	);
	
	var $hasMany = array(
		'Version' => array(
			'className' => 'Resources.ResourcesUpload',
			'foreignKey' => 'resource_id',
			'order' => array('Version.created' => 'desc')
		)
	);
	
	var $hasOne = array(
		'Current' => array(
			'className' => 'Resources.ResourcesUpload',
			'foreignKey' => 'resource_id',
			'order' => array('Current.created' => 'desc'),
		)
	);

	var $actsAs = array(
		'Tags.Taggable',
		'Uploads.Attachable',
		'Searchable.Searchable' => array(
			'fields' => array(
				'title', 'description', 'Tag.name'
			)
		)
	);
	
	public $_findMethods = array(
		'filter' => true,
		'index' => true
	);
	
	
	public function _findIndex($state, $query, $results = array())
	{
		if ($state === 'before') {
			$query['contain'] = array(
				'Batch',
				'Version' => array(
					'Upload' => array('fields' => array('id', 'path')),
					'fields' => array('id', 'version', 'comment'),
					'order' => array('Version.created' => 'desc'),
					'limit' => 1
				)
			);
			return $query;
		}
		foreach ($results as $key => $result) {
			$results[$key]['Version'] = $result['Version'][0];
			$results[$key]['Upload'] = $results[$key]['Version']['Upload'];
		}
		return $results;
	}
	
	public function _findFilter($state, $query, $results = array())
	{
		if ($state === 'before') {
			$query = $this->_findIndex($state, $query, $results);
			if (!empty($query['tags'])) {
				$tags = explode(',', $query['tags']);
				foreach ($tags as &$tag) {
					$tag = trim($tag);
					$tag = $this->multibyteKey($tag);
				}
				unset($query['conditions']['Tagged.by LIKE']);
				$extraQuery['conditions']['Tag.keyname'] = $tags;
			}
			$extraQuery['joins'] = array(
				array(
					'table' => 'tagged',
					'alias' => 'Tagged',
					'type' => 'INNER',
					'conditions' => array(
						'Tagged.foreign_key = Resource.id',
						'Tagged.model' => 'Resource'
					)
				),
				array(
					'table' => 'tags',
					'alias' => 'Tag',
					'type' => 'LEFT',
					'conditions' => array(
						'Tagged.tag_id = Tag.id'
					)
				)
			);
			$query = Set::merge($query, $extraQuery);
			$query['fields'][] = "DISTINCT " . join(',', $this->getDataSource()->fields($this));
			return $query;
		}
		return $this->_findIndex($state, $query, $results);
		return $results;
	}
	
/**
 * Create a version record
 *
 * @param string $id 
 * @param string $attachment_id 
 * @param string $comment 
 * @return boolean true on success
 */
	public function addVersion($id, $attachment_id, $comment = false)
	{
		if (!$this->id && !$id) {
			throw new OutOfBoundsException('Invalid ID');
		}
		
		if ($id) {
			$this->id = $id;
		}

		$countVersions = $this->lastVersion($id);

		if (empty($comment)) {
			$comment = sprintf(__d('resources', 'Adding version %s', true), $countVersions+1);
		}
	
		$data['Version'] = array(
			'resource_id' => $id,
			'upload_id' => $attachment_id,
			'version' => $countVersions+1,
			'comment' => $comment
		);
		$this->Version->create();
		return $this->Version->save($data);
	}

/**
 * Creates a new version from the last upload
 *
 * @param string $id 
 * @param string $comment 
 * @return void
 * @author Fran Iglesias
 */	
	public function autoAddVersion($id, $comment)
	{
		$file = $this->Upload->find('first', array(
			'fields' => array('id', 'created'),
			'conditions' => array(
				'model' => $this->alias,
				'foreign_key' => $this->id,
			),
			'order' => array(
				'created' => 'desc'
			)
		));
		return $this->addVersion($id, $file['Upload']['id'], $comment);
	}

/**
 * Reverts to a prior version
 *
 * @param string $id 
 * @param string $version_id 
 * @param string $comment 
 * @return boolean true on success
 */
	public function revert($id, $version_id, $comment = false)
	{
		if (!$this->id && !$id) {
			throw new OutOfBoundsException('Invalid ID');
		}
		if ($id) {
			$this->id = $id;
		}
		// Get the target version
		$version = $this->Version->find('first', array(
			'fields' => array('id', 'resource_id', 'upload_id', 'version'),
			'conditions' => array('id' => $version_id)
		));
		// Count versions to compute new version number
		$countVersions = $this->lastVersion($id);
		// Predefined comment
		if (empty($comment)) {
			$comment = sprintf(__d('resources', 'Revert changes to version %s', true), $version['Version']['version']);
		}
		// Data for the new version and save
		$data['Version'] = array(
			'resource_id' => $id,
			'upload_id' => $version['Version']['upload_id'],
			'version' => $countVersions+1,
			'comment' => $comment
		);
		$this->Version->create();
		return $this->Version->save($data);
	}

/**
 * Reads a full Resource
 *
 * @param string $fields 
 * @param string $id 
 * @return array
 */	
	public function retrieve($fields, $id)
	{
		$this->contain(array(
			'Tag',
			'Current' => array(
				'Upload'
			),
			'Version'
		));
		$data = $this->read($fields, $id);
		if (empty($data)) {
			return false;
		}
		$data['Current']['user_id'] = $data['Resource']['user_id'];
		return $data;
	}

/**
 * Computes last version for a resource
 *
 * @param string $id 
 * @return integer The version number
 */	
	public function lastVersion($id)
	{
		if (!$this->id && !$id) {
			throw new OutOfBoundsException('Invalid ID');
		}
		if ($id) {
			$this->id = $id;
		}
		
		$result = $this->Version->find('first', array(
			'fields' => array('MAX(version) as last'),
			'conditions' => array('resource_id' => $this->id)
		));
		return $result[0]['last'];
	}
	
}
