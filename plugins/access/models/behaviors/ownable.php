<?php
/**
 * Ownable behavior
 * 
 * Allows auto associate owners(users|groups) with objects including access permission
 * Unix style.
 * Also, allows AccessComponent to inject conditions into the model related to control
 * access, son you don't need to take into account in the actions
 *
 * @package access.milhojas
 * @version $Id$
 * @copyright Fran Iglesias
 **/

use Mh13\plugins\access\services\OwnerService;


if (!defined('ACCESS_READ')) {
	define('ACCESS_READ', 1);
}

if (!defined('ACCESS_WRITE')) {
	define('ACCESS_WRITE', 2);
}

if (!defined('ACCESS_DELETE')) {
	define('ACCESS_DELETE', 4);
}

if (!defined('ACCESS_ADMIN')) {
	define('ACCESS_ADMIN', 8);
}

if (!defined('ACCESS_MEMBER')) {
	define('ACCESS_MEMBER', 16);
}

if (!defined('ACCESS_NOT_MANAGED')) {
	define('ACCESS_NOT_MANAGED', 32);
}

class OwnableBehavior extends ModelBehavior implements OwnerService {
    const ACCESS_READ = 1;
    const ACCESS_WRITE = 2;
    const ACCESS_DELETE = 4;
    const ACCESS_ADMIN = 8;
    const ACCESS_MEMBER = 16;
    const ACCESS_NOT_MANAGED = 32;

/**
 * Contains configuration settings for use with individual model objects.
 * Individual model settings should be stored as an associative array, 
 * keyed off of the model name.
 *
 * @var array
 * @access public
 * @see Model::$alias
 */
	var $settings = array();
	
	var $defaults = array(
		'mode' => 'object', // object or owner
		);


/**
 * Allows the mapping of preg-compatible regular expressions to public or
 * private methods in this class, where the array key is a /-delimited regular
 * expression, and the value is a class method.  Similar to the functionality of
 * the findBy* / findAllBy* magic methods.
 *
 * @var array
 * @access public
 */
	var $mapMethods = array();

    /**
     * OwnableBehavior constructor.
     */
    public function __construct()
    {
        App::import('Model', 'Access.Ownership');

    }

//	var $mapMethods = array('/^_findRange$/' => '_findRange');
//  $Model->_findMethods['range'] = true;
// https://github.com/zeroasterisk/cakephp-behavior-rangeable/blob/master/models/behaviors/rangeable.php

/**
 * Bind the model with the Ownership model to store info about owner and
 * access
 *
 * @param object $model
 * @param array $config
 * @return void
 * @access public
 */
	function setup($model, $config = array()) {
		if (!is_array($config)) {
			$config = array('mode' => $config);
		}
		$this->settings[$model->alias] = array_merge($this->defaults, $config);
		
		$mode = $this->settings[$model->alias]['mode'];
		
		if ($mode == 'object') {
			$this->bindAsObject($model);
		} elseif ($mode == 'owner') {
			$this->bindAsOwner($model);
		}
	}


	public function beforeDelete($model, $cascade)
	{
		if ($this->settings[$model->alias]['mode'] == 'object') {
			$conditions = array(
				'object_model' => $model->alias,
				'object_id' => $model->id
			);
		} else {
			$conditions = array(
				'owner_model' => $model->alias,
				'owner_id' => $model->id
			);
		}
		return ClassRegistry::init('Ownership')->deleteAll($conditions);
	}
/**
 * Binds a model as object, so it could be owned by another objects,
 * (mainly users or groups or similar)
 *
 * @param string $model 
 * @return void
 */
	public function bindAsObject($model) {
		$bindSettings = array(
			'OwnedBy' => array(
				'className' => 'Access.Ownership',
				'conditions' => array(
					'object_model' => $model->alias
					),
				'foreignKey' => 'object_id',
				'dependent' => true,
				'exclusive' => false
				)
			);
		$model->bindModel(array('hasMany' => $bindSettings), false);
		$ownerSettings = array(
			$model->alias => array(
				'className' => $model->alias,
				'foreignKey' => 'owner_id'
			)
		);
		ClassRegistry::init('Ownership')->bindModel(array('belongsTo' => $ownerSettings), false);
	
	}

/**
 * Binds a model as Owner, so it could own another objects
 *
 * @param string $model 
 * @return void
 */	
	public function bindAsOwner($model) {
		$bindSettings = array(
			'Owns' => array(
				'className' => 'Access.Ownership',
				'conditions' => array(
					'owner_model' => $model->alias
					),
				'foreignKey' => 'owner_id',
				'dependent' => true,
				'exclusive' => false
				)
			);
		$model->bindModel(array('hasMany' => $bindSettings), false);
		$ownerSettings = array(
			$model->alias => array(
				'className' => $model->alias,
				'foreignKey' => 'object_id'
			)
		);
		ClassRegistry::init('Ownership')->bindModel(array('belongsTo' => $ownerSettings), false);
	}


/**
 * Attach current model record to an owner object with certain permissions
 *
 * @param object $model 
 * @param mixed array o model object
 * @return string|boolean
 */	
	public function addOwner($model, $owner, $permissions = 15, $id = null) {

		if ($this->isOwner($this, $User)) {
            return $this->modifyOwnerPermissions($this, $User, $permissions);
        }

        $model->setId($id);
		
		$data = array(
			'Ownership' => array(
				'owner_model' => $owner->alias,
				'owner_id' => $owner->id,
				'object_model' => $model->alias,
				'object_id' => $model->id,
				'access' => $permissions
				)
			);
		$ownership = ClassRegistry::init('Ownership');
		$ownership->create();
		
		if (!$ownership->save($data)) {
			throw new RuntimeException('Unable to save data');
		}
		return $ownership->getLastInsertId();
	}


/**
 * Remove the relation between object and owner
 *
 * @param string $model 
 * @param string $owner 
 * @param string $id 
 * @return bool
 */
	public function removeOwner($model, $owner, $id = null) {
		$model->setId($id);
		return ClassRegistry::init('Ownership')->deleteAll(array(
				'owner_model' => $owner->alias,
				'owner_id' => $owner->id,
				'object_model' => $model->alias,
				'object_id' => $model->id
			));
	}


/**
 * Change permissions.
 *
 * @param string $model 
 * @param string $owner 
 * @param string $newPermissions 
 * @param string $id 
 * @return string|boolean
 */
	public function modifyOwnerPermissions($model, $owner, $newPermissions, $id = null) {
		$model->setId($id);
		$conditions = array(
				'owner_model' => $owner->alias,
				'owner_id' => $owner->id,
				'object_model' => $model->alias,
				'object_id' => $model->id
			);
		return ClassRegistry::init('Ownership')->updateAll(array('access' => $newPermissions), $conditions);
	}

/**
 * Checks if a given owner is tied with an object
 * Wrapper for whatAccess
 *
 * @param string $model 
 * @param string $owner 
 * @param string $id 
 * @return bool
 */
	public function isOwner($model, $owner, $id = null) {
		return $this->whatAccess($model, $owner, $id) > 0;
	}
	
/**
 * Checks if an owner is tied to an object and returns access permissions
 *
 * @param string $model 
 * @param string $owner 
 * @param string $id 
 * @return bool|integer
 */	
	public function whatAccess($model, $owner, $id = null) {
		$model->setId($id);

		$conditions = array(
				'owner_model' => $owner->alias,
				'owner_id' => $owner->id,
				'object_model' => $model->alias,
				'object_id' => $model->id
			);
		$fields = array('Ownership.access');
		$result = ClassRegistry::init('Ownership')->find('all', compact('fields', 'conditions'));
		if (!$result) {
			return false;
		}
		return $result[0]['Ownership']['access'];
	}


/**
 * Retrieves Owner not tied with Object
 *
 * @return array
 **/
	public function notOwners($model, $ownerModel, $extraQuery = array()) {
		$query = array(
			'fields' => array(
				$ownerModel.'.*',
				'Owner.access'
				),
			'joins' => array(
				array(
					'table' => 'ownerships',
					'alias' => 'Owner',
					'type' => 'left',
					'conditions' => array(
						'Owner.owner_model' => $ownerModel,
						'Owner.object_model' => $model->alias,
						'Owner.object_id' => $model->id,
						"Owner.owner_id = {$ownerModel}.id"
						)
					)
				),
			'conditions' => array('Owner.access' => null)
		);
		$query = Set::merge($query, $extraQuery);
		$Owner = ClassRegistry::init($ownerModel);
		return $Owner->find('all', $query);

	}

/**
 * Retrieves Owners tied with an object
 *
 * @param string $model 
 * @param string $ownerModel 
 * @param string $extraQuery 
 * @return array
 */
	public function owners($model, $ownerModel, $extraQuery = array())
	{
		$query = array(
			'fields' => array(
				$ownerModel.'.*',
				'Owner.access'
				),
			'joins' => array(
				array(
					'table' => 'ownerships',
					'alias' => 'Owner',
					'type' => 'left',
					'conditions' => array(
						'Owner.owner_model' => $ownerModel,
						'Owner.object_model' => $model->alias,
						'Owner.object_id' => $model->id,
						"Owner.owner_id = {$ownerModel}.id"
						)
					)
				),
			'conditions' => array('Owner.access !=' => null)
		);
		$query = Set::merge($query, $extraQuery);
		$Owner = ClassRegistry::init($ownerModel);
		return $Owner->find('all', $query);
	}



} // End of MyBehavior

?>
