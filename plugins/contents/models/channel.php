<?php

App::import('Model', 'Contents.Site');
App::import('Model', 'Access.User');

class Channel extends ContentsAppModel {
	const OWNER = 63; //ACCESS_READ + ACCESS_WRITE + ACCESS_DELETE + ACCESS_ADMIN + ACCESS_MEMBER + ACCESS_NOT_MANAGED
	const EDITOR = 56; //ACCESS_ADMIN + ACCESS_MEMBER + ACCESS_NOT_MANAGED
	const AUTHOR = 48; //ACCESS_MEMBER + ACCESS_NOT_MANAGED
	const CONTRIBUTOR = 16; //ACCESS_MEMBER
	const ADMIN = 8;
	
	var $name = 'Channel';
	var $displayField = 'title';

	var $belongsTo = array(
		'Menu' => array(
			'className' => 'Menus.Menu',
			'foreignKey' => 'menu_id'
		) 
	);

	var $hasMany = array(
		'Item' => array(
			'className' => 'Contents.Item',
			'foreignKey' => 'channel_id',
			'dependent' => true,
		),
		'Label' => array(
			'className' => 'Labels.Label',
			'foreignKey' => 'owner_id',
			'conditions' => array(
				'Label.owner_model' => 'Channel'
			)
		)
	);

	var $hasAndBelongsToMany = array(
		'Role' => array(
			'className' => 'Access.Role',
		),
		'Site' => array(
			'className' => 'Contents.Site'
		)
	);
	
	var $actsAs = array(
		'Licenses.Licenseable',
		'Access.Ownable' => array('mode' => 'object'),
		'Access.Authorizable',
		'Translate' => array(
			'title',
			'description',
			'slug',
			'tagline'
			),
		'Ui.Sluggable',
		'Uploads.Upable' => array(
			'icon' => array(
				'move' => 'route',
				'return' => 'link'
				),
			'image' => array(
				'move' => 'route',
				'return' => 'link'
				)
			)
		);
		
	var $validate = array(
		'title' => array(
			'required' => array(
				'rule' => 'notEmpty'
				)
			)
		);
	
	/**
	 * User roles in a channel
	 *
	 *	'role' => permissions
	 *
	 * @var array
	 **/
	var $roles = array(
		self::OWNER => 'owner',
		self::EDITOR => 'editor',
		self::AUTHOR => 'author',
		self::CONTRIBUTOR => 'contributor'
	);
	
	/**
	 * virtual and calculated fields
	 *
	 * @var string
	 */
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		// Backend find methods
		$this->_findMethods['user'] = true;
		$this->_findMethods['admin'] = true;
		// Public find methods
		$this->_findMethods['catalog'] = true;
	}
	
/**
 * beforeSave callback
 *
 *	Ensures Channel credentials are null if they are empty
 *
 * @param array $options 
 * @return boolean false if callback should abort saving
 * @test
 */
	public function beforeSave($options = array())
	{
		if ($this->id) {
			if ($this->shouldBePrivate()) {
				$this->makePrivate($this->data['Role']['Role']);
			}
			if ($this->shouldBePublic()) {
				$this->makePublic();
			}
		}
		return true;
	}
	
		private function shouldBePrivate()
		{
			return isset($this->data['Role']) && !empty($this->data['Channel']['private']);
		}
	
		private function shouldBePublic()
		{
			return empty($this->data['Channel']['private']);
		}
	
	public function init() 
	{
		foreach ($this->translatedFields() as $field) {
			$new[$field] = '';
		}

		$new = array_merge($new, array(
			'home' => 0,
			'active' => 0,
			'title' => __d('contents', 'Untitled channel', true)
		));
		$this->set($new);
	}


	
/**
 * Return the ids of private channels, both guest/pwd and private for logged users
 *
 * @return array od channel id
 * @test
 */
	public function restricted()
	{
		$private = $this->find('all', array(
			'fields' => array('id'),
			'conditions' => array('Channel.private' => 1)
			)
		);
		return Set::extract($private, '/Channel/id'); 
	}


/**
 * PUBLIC FIND METHODS
 *
 * Methods to retrieve readable channels for visitors or logged-in users 
 */
		
	public function findActive($user = false)
	{
		$channels = $this->find('catalog', array(
			'fields' => array(
				'Channel.id',
				'Channel.title',
				'Channel.slug',
				'Channel.icon',
                'CHannel.image',
				'Channel.description',
				'Channel.type',
				'Channel.active',
				'Channel.private',
				'Channel.tagline'
			),
			'user' => $user,
			'order' => array(
				'I18n__title.content' => 'asc'
			)
		));
		return $channels;
	}
	
	public function listActive()
	{
		return $this->find('list', array(
			'conditions' => array('Channel.active' => 1),
			'order' => array('I18n__title.content' => 'asc')
		));
	}
	
	public function findExternal()
	{
		return $this->find('all', array(
			'fields' => array(
				'Channel.id',
				'Channel.slug',
				'Channel.title',
				'Channel.icon'
			),
			'conditions' => array('Channel.active' => 1, 'Channel.external' => 1),
			'order' => array('I18n__title.content' => 'asc')
		));
	}
	
	public function findBySite($site, $user = false)
	{
		$channels = $this->find('catalog', array(
			'fields' => array(
				'Channel.id',
				'Channel.title',
				'Channel.slug',
				'Channel.icon',
                'Channel.image',
				'Channel.description',
				'Channel.type',
				'Channel.active',
				'Channel.private',
			),
			'site' => $site,
			'user' => $user,
			'order' => array(
				'I18n__title.content' => 'asc'
			)
		));
		return $channels;
	}

    public function getBySlugAndUserOrFail($slug, $user = false)
	{
		$channels = $this->find('catalog', array(
			'slug' => $slug,
			'user' => $user,
			'limit' => 1
		));
		if (!$channels) {
            throw new \InvalidArgumentException(sprintf('Channel %s not found', $slug));
		}
		$this->data = array_shift($channels);
		$this->id = $this->data['Channel']['id'];
	}

	public function _findCatalog($state, $query, $results = array())
	{
		if ($state === 'before') {
			if (empty($query['user'])) {
				$conditions = array('Channel.private' => 0);
			} else {
				$User = ClassRegistry::init('User');
				$User->load($query['user']);
				$conditions = array(
					'or' => array(
						'Channel.private' => 0,
						'Channel.id' => $this->getPrivate($User)
					)
				);
			}
			$conditions['active'] = true;
			if (isset($query['slug'])) {
				if (!empty($query['slug'])) {
					$query['conditions']['I18n__slug.content'] = $query['slug'];
				} else {
					$query['conditions']['I18n__slug.content'] = '';
				}
			}
			
			if (!empty($query['site'])) {
				$conditions['Channel.id'] = ClassRegistry::init('Site')->getChannelsIds($query['site']);
			}
			return Set::merge($query, compact('conditions'));
		}
		return $results;
	}


/**
 * ADMINISTRATIVE METHODS
 *
 * Retrieve channels based on the abilitiy of the user to edit or use them
 */

    public function _findAdmin($state, $query, $results = array())
    {
        if ($state === 'before') {
            $query['fields'] = array('Channel.id', 'Channel.title', 'Channel.active', 'Channel.external');
            $query['order'] = array('I18n__title.content' => 'asc');
            if (!empty($query['user'])) {
                $query['access'] = self::OWNER;
                $query = $this->_findUser('before', $query, $results);
            }

            return $query;
        }

        return $results;
    }

/**
 * Generic base method to find channels for a user
 *
 * @param string $state
 * @param string $query array('user_id' => the_user_id)
 * @param string $query array('access' => access level)
 * @param string $results
 *
*@return array list of values Channel.id => Channel.title Localized
 */
	public function _findUser($state, $query, $results = array()) {
		$this->unbindModel(array('hasMany' => array('Owner')));
		if ($state === 'before') {
			$extraQuery = array(
				'callbacks' => true,
				'conditions' => array(
					'Owner.access & '.$query['access'].' = '. $query['access']
					),
				'joins' => array(
					array(
						'table' => 'ownerships',
						'alias' => 'Owner',
						'type' => 'LEFT',
						'foreignKey' => FALSE,
						'conditions' => array(
							'Owner.object_model' => 'Channel',
							'Owner.object_id = Channel.id',
							'Owner.owner_model' => 'User',
							'Owner.owner_id' => $query['user']
						)
					),
				)
			);
			return Set::merge($query, $extraQuery);
		}
		return $results;
	}

/**
 * List of channels available for a given user
 *
 */
	
	public function findAvailable($user = false)
	{
		if (!$user) {
			$channels = $this->find('all', array(
				'fields' => array('Channel.id', 'Channel.title'),
				'order' => array(
					'I18n__title.content' => 'asc'
				)
			));
		} else {
			$channels = $this->find('user', array(
				'fields' => array('Channel.id', 'Channel.title'),
				'user' => $user,
				'access' => self::CONTRIBUTOR,
				'order' => array(
					'I18n__title.content' => 'asc'
				)
			));
		}
		return Set::combine($channels, '/Channel/id', '/Channel/title');
	}
	

/**
 * Channels where a user is member
 *
 * @param string $state 
 * @param string $query 
 * @param string $results
 *
 * @return array
 */

	public function findMember($user)
	{
		return $this->find('user', array(
			'fields' => array(
				'Channel.id',
				'Channel.title',
				'Channel.slug',
				'Owner.access'
			),
			'user' => $user,
			'access' => self::CONTRIBUTOR
		));
	}


	public function labels($id = null)
	{
		$this->setId($id);
        $this->read(null, $id);
		return $this->Item->labels($this->id);
	}

/**
 * Return a list of Users not associated with the Channel, so they are "candidates"
 * when we need to add users to it
 *
 * @param string $channel_id
 *
 * @return array * @test
 */	
	public function notMembers() {
		return Set::combine(
			$this->Behaviors->Ownable->notOwners($this, 'User'), 
			'/User/id', 
			'/User/realname'
		);
	}
	
	public function notMembersStartingWith($term) {
		return Set::combine(
			$this->Behaviors->Ownable->notOwners($this, 'User', array('conditions' => array(
				'User.realname like' => $term.'%'
			))), 
			'/User/id', 
			'/User/realname'
		);
	}
	
	
	public function members()
	{
		return $this->Behaviors->Ownable->owners($this, 'User', array('fields' => array(
			'User.id', 
			'User.realname', 
			'Owner.access'
		)));
	}
	

/**
 * Get a list of people with edior privileges in a given channel
 *
 * @param string $id 
 * @return array of User or false
 */

	public function editors()
	{
		return $this->Behaviors->Ownable->owners($this, 'User', array(
			'fields' => array(
				'User.id', 
				'User.realname', 
				'User.email', 
				'Owner.access'
				), 
			'conditions' => array(
				'Owner.access & '. self::EDITOR
				)
		));
	}
	
/**
 * Associate a User to a Channel
 *
 * @param string $user_id The User.id
 * @param string $permissions Channel::OWNER, Channel::EDITOR, Channel::AUTHOR, Channel::CONTRIBUTOR
 * @return boolean true on success
 * @test
 */
	public function bind(User $User, $permissions)
	{
		if (!$this->arePermissionsValid($permissions)) {
			return false;
		}
		if ($this->Behaviors->Ownable->isOwner($this, $User)) {
			return $this->Behaviors->Ownable->modifyOwnerPermissions($this, $User, $permissions);
		}
		return $this->Behaviors->Ownable->addOwner($this, $User, $permissions);
	}

    private function arePermissionsValid($permissions)
    {
        return in_array(
            $permissions,
            array(
                self::OWNER,
                self::EDITOR,
                self::AUTHOR,
                self::CONTRIBUTOR,
            )
        );
    }
	
	public function unbind(User $User)
	{
		if ($this->Behaviors->Ownable->isOwner($this, $User)) {
			return $this->Behaviors->Ownable->removeOwner($this, $User);
		}
	}
	
	public function role(User $User)
	{
		$access = $this->Behaviors->Ownable->whatAccess($this, $User);
		if ($access) {
			return $this->roles[$access];
		}
		return false;
	}

/**
 * Returns id of a channel using its slug
 *
 * @param string $slug could be an UUID or a slug. If match an UUID pattern then returns it.
 * If not, tries to guess the UUID looking into DB if needed
 * @return string The id
 */


	public function idFromSlug($slug)
	{
		if ($this->isAnUUID($slug)) {
			return $slug;
		}
		$this->getBySlug($slug);
		return $this->id;
	}

	private function isAnUUID($slug)
	{
		if (preg_match('/[[:xdigit:]]{8,8}-[[:xdigit:]]{4,4}-[[:xdigit:]]{4,4}-[[:xdigit:]]{4,4}-[[:xdigit:]]{12,12}/', $slug)) {
			return true;
		}
		return false;
	}


	public function getBySlug($slug)
	{
		$id = ClassRegistry::init('I18nModel')->find('first', array(
			'fields' => 'foreign_key',
			'conditions' => array(
				'model' => 'Channel',
				'field' => 'slug',
				'content' => $slug
			)
		));
		if (!$id) {
			$this->id = false;
			$this->data = false;
			return;
		}
		$this->load($id['I18nModel']['foreign_key']);
	}

	public function findSlugs($slugs)
	{
		$result = ClassRegistry::init('I18nModel')->find('all', array(
			'fields' => 'foreign_key',
			'conditions' => array(
				'model' => 'Channel',
				'field' => 'slug',
				'or' => array(
					'content' => $slugs,
					'foreign_key' => $slugs
				)
				
			)
		));
		return Set::extract('/I18nModel/foreign_key', $result);
	}
	
	public function getDefaults()
	{
		$this->read(array('license_id', 'default_comments', 'home'));
		return $this->data['Channel'];
	}
	
}
?>
