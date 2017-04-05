<?php

App::import('Model', 'Contents.Site');
App::import('Model', 'Contents.Channel');

class Item extends ContentsAppModel
{
    const NEIGHBORS_MARGIN = 14;
    const AUTHOR = 23;
    const COAUTHOR = 19;
    const DRAFT = 0;
    const REVIEW = 1;
    const PUBLISHED = 2;
    const EXPIRED = 3;
    const RETIRED = 4;
    const WAITING = 5;
    public $name = 'Item';
    public $displayField = 'title';

    public $belongsTo = array(
        'Channel' => array(
            'className' => 'Contents.Channel',
            'foreignKey' => 'channel_id',
        ),
    );

    public $actsAs = array(
        'Tree',
        'Ui.Sluggable' => array('update' => true, 'lenght' => 200),
        'Licenses.Licenseable',
        'Access.Ownable' => array('mode' => 'object'),
        'Ui.Duplicable' => array(
            'changeFields' => 'title',
            'changeString' => 'Copia de %s',
            'cascade' => true,
            'associations' => array(
                'OwnedBy',
                ),
            'callbacks' => true,
            ),
        'Labels.Labellable',
        'Uploads.Attachable' => array(
            'MainImage',
            'Image',
            'Enclosure',
            'Download',
            'Multimedia',
            ),
        'Searchable.Searchable' => array('fields' => array('title', 'content')),
        );

    public $validate = array(
        'title' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'on' => 'update',
                ),
            ),
        'content' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'on' => 'update',
                ),
            ),

        );

    public $statuses = array(
        'draft' => 0,
        'review' => 1,
        'published' => 2,
        'expired' => 3,
        );

    /**
     * Extra keys needed for find('catalog').
     *
     * @var array
     */
    public $queryKeys = array(
        'siteName' => false,            // Site (set of channels with same tags)
        'channelList' => false,            // List of channels to include
        'featured' => false,        // Include only featured or sticky items
        'sticky' => false,            // Force sticky items to be listed at the top of the list
        'limit' => 0,            // Retrieve n items
        'offset' => 0,                // Retrieve items starting at offset
        'exclude' => false,            // List of channels to exclude
        'excludePrivate' => false,    // Exclude private channels
        'home' => false,
        'tag' => false,
        'label' => false,
        'level' => false,
    );

    /**
     * Conditions sets for custom Find, so we have a unique point to edit.
     *
     * @var string
     */
    public $conditions = array(
        'published' => array(
            'Item.status' => self::PUBLISHED,
            'Item.pubDate <= now()',
            'or' => array(
                'Item.expiration is null',
                'Item.expiration > now()',
                ),
            'Channel.active' => true,
            ),
        'search' => array(
            array(
                'or' => array(
                    'Item.status' => self::PUBLISHED,
                    array(
                        'Item.status' => self::EXPIRED,
                        'Item.search_if_expired' => 1,
                        ),
                    ),
                ),
            'Item.pubDate <= now()',
            'or' => array(
                'Item.expiration is null',
                'Item.expiration > now()',
                array(
                    'Item.expiration is not null',
                    'Item.search_if_expired' => 1, ),
                ),
            'Channel.active' => true,
            ),

        );

    public $virtualFields = array(
        'real_status' => 'IF(Item.status = 2,IF(Item.pubDate > CURDATE(),5,IF(Item.expiration > CURDATE() or Item.expiration is null, 2, 3)), IF(Item.status = 1, 1, IF(Item.status = 3, 4, 0)))',
    );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        // $this->_findMethods['published'] = true;
        $this->_findMethods['user'] = true;
        $this->_findMethods['dashboard'] = true;
        $this->_findMethods['catalog'] = true;
        $this->_findMethods['responsible'] = true;
        $this->_findMethods['channel'] = true;
    }

    /**
     * Builds a search query combining the catalog find method with the search terms.
     * This ensures a consistent behavior in all data retrieving operations.
     *
     * @param string $term
     *
     * @return array the query
     * @test
     */
    public function buildSearchQuery($term)
    {
        $query = $this->_findSearch('before', array('term' => $term));
        $query['mode'] = 'search';
        $query[0] = 'catalog';

        return $query;
    }

    public function afterDelete()
    {
        $this->removeCache();
    }

    /**
     * Remove caches related to an Item. The cache file name (key) is built as a slug of the URl taking care of Cake Routes,
     * so we use the Router to compute it.
     *
     * @param string $id mixed null remove elements cache, id is an id or an array of them
     * @test
     */
    public function removeCache($id = null)
    {
        $this->_deleteCache('mh_contents');
        if (!$id && !$this->data['Item']) {
            return;
        }
        if ($id) {
            $slugs = Set::extract(
                $this->find('all', array(
                    'fields' => array('Item.slug'),
                    'conditions' => array('Item.id' => $id),
                    )),
                '/Item/slug'
            );
        } else {
            $slugs = $this->data['Item']['slug'];
        }

        $files = array();
        foreach ((array) $slugs as $slug) {
            $this->_deleteCache($slug.'.php');
        }

        return $files;
    }

    /**
     * Callback for Duplicable behavior.
     *
     * @test
     */
    public function afterDuplicate()
    {
        $this->set(array(
            'status' => self::DRAFT,
            'pubDate' => date('Y-m-j'),
            'expiration' => null,
            'readings' => 0,
        ));
    }

    /**
     * Get default properties from the Channel and populate translated
     * fields to avoid creation problems.
     *
     * @param string $channel_id
     */
    public function init($channelId)
    {
        $this->Channel->setId($channelId);
        $new = $this->Channel->getDefaults();
        foreach ($this->translatedFields() as $field) {
            $new[$field] = '';
        }
        $new['status'] = self::DRAFT;
        $new['gallery'] = 'lightbox';
        $new['channel_id'] = $this->Channel->getID();
        $this->set($new);
    }

    /**
     * Returns the role of the user, identified by user_id, in the channel of the current item.
     *
     * @param string $user_id
     *
     * @author Fran Iglesias
     */
    public function getRoleForUser($User)
    {
        $this->Channel->load($this->field('channel_id'));

        return $this->Channel->role($User);
    }

    public function select($params)
    {
        $this->recursive = 1;

        return $this->find('catalog', $this->queryFromParams($params));
    }

    public function queryFromParams($params)
    {
        return array_intersect_key(array_merge($this->queryKeys, $params), $this->queryKeys);
    }

    public function _findChannel($state, $query, $results = array())
    {
        if ($state === 'before') {
            $query['channelList'] = array($query['channel']);
            unset($query['channel']);
            $query['sticky'] = true;
            $query['limit'] = Configure::read('Theme.limits.page');

            return $this->_findCatalog('before', $query, $results);
        }

        return $this->_findCatalog('after', $query, $results);
    }

    /**
     * Custom find to retrieve published items for index pages, including expired items if
     * the search_if_expired flag is true.
     *
     * @param string $state
     * @param string $query
     *
     * extra keys:
     *
     *       siteName: selects channels related to a site via tags as key (equal to slug)
     *    channelList: selects items from a channel or a list of channels (channel and site are mutually exclusive) as slug
     *        exclude: list of channels to exclude in a catalog
     *       featured: restricts items to featured and sticky
     *           home: restricts to items marked as home
     *         sticky: sorts items so sticky are always at the beginning
     *            tag: restricts items to those tagged with a tag or list of them
     * excludePrivate: true = exclude items from private channels
     * @param string $results
     *
     * @return array of false
     * @test
     */
    public function _findCatalog($state, $query, $results = array())
    {
        if ($state === 'before') {
            $this->manageChannelExclusion($query);
            $this->manageChannelInclusion($query);
            $this->restrictToFeatured($query);
            $this->manageOrder($query);

            $joins = array(
                $this->joinItemChannel(),
            );

            if (!empty($query['label'])) {
                $query['conditions']['Label.id'] = $query['label'];
                $joins[] = $this->joinItemLabelled();
                $joins[] = $this->joinLabels();
                unset($query['label']);
            }

            if (!empty($query['level'])) {
                $query['conditions']['level_id'] = $query['level'];
                unset($query['level']);
            }

            if (empty($query['limit'])) {
                $query['limit'] = Configure::read('Theme.limits.page');
            }

            foreach ($joins as $join) {
                $query['joins'][] = $join;
            }

            return Set::merge($query, $this->baseQuery($query));
        }
        // Results manipulation
        if (!$results) {
            return false;
        }
        foreach ($results as &$item) {
            $this->removeOwnershipData($item);
            $this->normalizeScoreData($item);
            $this->changeContentsIfRestricted($item);
        }

        return $results;
    }

    private function manageChannelExclusion(&$query)
    {
        $excludeChannels = array();
        if (!empty($query['excludePrivate'])) {
            $excludeChannels = $this->Channel->restricted();
            unset($query['excludePrivate']);
        }

        if (!empty($query['exclude'])) {
            $excludeChannels = array_merge($excludeChannels, $this->Channel->findSlugs($query['exclude']));
            unset($query['exclude']);
        }

        if (!empty($excludeChannels)) {
            $query['conditions']['NOT']['Item.channel_id'] = $excludeChannels;
        }
    }

    public function manageChannelInclusion(&$query)
    {
        if (!empty($query['siteName'])) {
            $query['conditions']['Item.channel_id'] = ClassRegistry::init('Site')->getChannelsIds($query['siteName']);
            unset($query['siteName']);
        } elseif (!empty($query['channelList'])) {
            $query['conditions']['Item.channel_id'] = $this->Channel->findIdFromSlugs($query['channelList']);
            unset($query['channelList']);
        }
    }

    private function restrictToFeatured(&$query)
    {
        // Only featured or stick items
        if (!empty($query['featured'])) {
            $query['conditions'][] = array(
                'or' => array(
                    'Item.stick' => true,
                    'Item.featured' => true,
                ),
            );
            unset($query['featured']);
        }
    }

    private function manageOrder(&$query)
    {
        $order = array(
            'Item.pubDate' => 'desc',
            'Item.featured' => 'desc',
            'Item.created' => 'desc',
        );
        if (!empty($query['sticky'])) {
            $order = array_merge(array('Item.stick' => 'desc'), $order);
            unset($query['sticky']);
        }

        if (isset($query['order'])) {
            $query['order'] = array_merge($order, $query['order']);
        } else {
            $query['order'] = $order;
        }
    }

    private function joinItemChannel()
    {
        return array(
            'table' => 'channels',
            'alias' => 'Channel',
            'type' => 'left',
            'conditions' => array('Item.channel_id = Channel.id'),
        );
    }

    private function joinItemLabelled()
    {
        return array(
            'table' => 'labelled',
            'alias' => 'Labelled',
            'type' => 'LEFT',
            'foreignKey' => false,
            'conditions' => array(
                'Labelled.model' => 'Item',
                'Labelled.foreign_key = Item.id',
            ),
        );
    }

    public function joinLabels()
    {
        return array(
            'table' => 'labels',
            'alias' => 'Label',
            'type' => 'LEFT',
            'foreignKey' => false,
            'conditions' => array(
                'Labelled.label_id = Label.id',
            ),
        );
    }

    private function baseQuery(&$query)
    {
        if (empty($query['mode'])) {
            $query['mode'] = 'published';
        }

        $extraQuery = array(
            'conditions' => $this->conditions[$query['mode']],
            'contain' => array('MainImage' => array('fields' => 'path', 'limit' => 1)),
            'fields' => array(
                'Item.*',
                'Channel.active',
                'Channel.title',
                'Channel.slug',
            ),
        );
        unset($query['mode']);

        return $extraQuery;
    }

    public function removeOwnershipData(&$item)
    {
        if (!isset($item['User'])) {
            return;
        }
        foreach ($item['User'] as $key => $user) {
            unset($item['User'][$key]['Ownership']);
        }
    }

    private function normalizeScoreData(&$item)
    {
        if (isset($item[0]['score'])) {
            $item['Item']['score'] = $item[0]['score'];
            unset($item[0]['score']);
        }
    }

    private function changeContentsIfRestricted(&$item)
    {
        if (!empty($item['Item']['guest'])) {
            $item['Item']['content'] = __d(
                'contents',
                'The author has marked this item as Private. You will need a password to see it.',
                true
            );
        }
    }

    /**
     * Custom find to retrieve items that should show in the dashboard panel.
     *
     * @param string $state
     * @param string $query
     * @param string $results
     *
     * @return array
     */
    public function _findDashboard($state, $query, $results = array())
    {
        if ($state === 'before') {
            $user_id = $query['user'];
            unset($query['user']);
            $fields = array(
                'Item.*',
                'Channel.title',
                'Author.access',
                'Member.access',
            );
            $joins = array(
                array(
                    'table' => 'ownerships',
                    'alias' => 'Author',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array(
                        'Author.object_model' => 'Item',
                        'Author.object_id = Item.id',
                        'Author.owner_model' => 'User',
                        'Author.owner_id' => $user_id,
                        ),
                    ),
                array(
                    'table' => 'ownerships',
                    'alias' => 'Member',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Member.object_model' => 'Channel',
                        'Member.object_id = Item.channel_id',
                        'Member.owner_model' => 'User',
                        'Member.owner_id' => $user_id,
                    ),
                ),
            );
            $conditions = array(
                'or' => array(
                    'Member.access & '.Channel::ADMIN.' = '.Channel::ADMIN,
                    array(
                        'Member.access & '.Channel::AUTHOR.' = '.Channel::AUTHOR,
                        'Author.access & '.self::AUTHOR.' = '.self::AUTHOR,
                        ),
                    array(
                        'Member.access & '.Channel::CONTRIBUTOR.' = '.Channel::CONTRIBUTOR,
                        'Author.access & '.self::AUTHOR.' = '.self::AUTHOR,
                        'Item.status' => self::DRAFT,
                        ),
                    ),
                'Item.status <' => self::PUBLISHED,
            );
            $order = array(
                'Item.pubDate' => 'desc',
            );

            return Set::merge($query, compact('fields', 'joins', 'conditions', 'order'));
        }
        $results['count'] = count($results);

        return $results;
    }

    /**
     * Find items editable by the user.
     *
     * @param string $state
     * @param string $query
     * @param string $results
     */
    public function _findUser($state, $query, $results = array())
    {
        if ($state === 'before') {
            $user_id = $query['user'];
            unset($query['user']);
            $fields = array(
                'Item.id', 'Item.pubDate', 'Item.title', 'Item.status', 'Item.home', 'Item.featured', 'Item.stick', 'Item.allow_comments', 'Item.readings', 'Item.channel_id', 'Item.real_status',
                'Channel.title',
                'Author.access',
                'Member.access',
            );
            $joins = array(
                array(
                    'table' => 'ownerships',
                    'alias' => 'Author',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array(
                        'Author.object_model' => 'Item',
                        'Author.object_id = Item.id',
                        'Author.owner_model' => 'User',
                        'Author.owner_id' => $user_id,
                        ),
                    ),
                array(
                    'table' => 'ownerships',
                    'alias' => 'Member',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Member.object_model' => 'Channel',
                        'Member.object_id = Item.channel_id',
                        'Member.owner_model' => 'User',
                        'Member.owner_id' => $user_id,
                    ),
                ),

            );
            $conditions = array(
                'or' => array(
                    'Member.access & '.Channel::ADMIN.' = '.Channel::ADMIN,
                    array(
                        'Member.access & '.Channel::AUTHOR.' = '.Channel::AUTHOR,
                        'Author.access & '.self::AUTHOR.' IN ('.self::COAUTHOR.', '.self::AUTHOR.')',
                    ),
                    array(
                        'Member.access & '.Channel::CONTRIBUTOR.' = '.Channel::CONTRIBUTOR,
                        'Author.access & '.self::AUTHOR.' IN ('.self::COAUTHOR.', '.self::AUTHOR.')',
                        'Item.status' => self::DRAFT, ),
                    ),
                );
            $order = array(
                'Item.pubDate' => 'desc',
            );
            $query = Set::merge($query, compact('fields', 'joins', 'conditions', 'order'));

            return $query;
        }
        // Results manipulation
        return $results;
    }

    /**
     * Custom find to get the user responsible for a Item in order to moderate comments, etc.
     *
     * @param string $state
     * @param string $query
     * @param string $results
     */
    public function _findResponsible($state, $query, $results = array())
    {
        if ($state === 'before') {
            $user_id = $query['user'];
            unset($query['user']);
            $fields = array(
                'Item.id',
                'Author.access',
                'Member.access',
            );
            $joins = array(
                array(
                    'table' => 'ownerships',
                    'alias' => 'Author',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array(
                        'Author.object_id = Item.id',
                        'Author.owner_id' => $user_id,
                        'Author.owner_model' => 'User',
                        'Author.object_model' => 'Item',
                        ),
                    ),
                array(
                    'table' => 'ownerships',
                    'alias' => 'Member',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Member.object_model' => 'Channel',
                        'Member.object_id = Item.channel_id',
                        'Member.owner_model' => 'User',
                        'Member.owner_id' => $user_id,
                    ),
                ),
            );
            $conditions = array(
                'or' => array(
                    'Member.access & '.Channel::ADMIN.' = '.Channel::ADMIN,
                    array('Member.access & 48 = 48', 'Author.access & 23 = 23'),
                    array('Member.access & 16 = 16', 'Author.access & 23 = 23', 'Item.status' => 0),
                    ),
                );
            $query = Set::merge($query, compact('fields', 'joins', 'conditions'));

            return $query;
        }
        return $results;
    }

    /**
     * Things to do with model data before saving it.
     *
     * @param string $options
     */
    public function beforeSave($options = array())
    {
        $this->ensureExpirationIsNullIfEmpty();
        $this->ensurePubDateHasAValue();
        $this->removeCacheIfItemExists();

        return true;
    }

    private function ensureExpirationIsNullIfEmpty()
    {
        if (empty($this->data['Item']['expiration'])) {
            $this->data['Item']['expiration'] = null;
        }
    }

    private function ensurePubDateHasAValue()
    {
        if (empty($this->data['Item']['pubDate'])) {
            $this->data['Item']['pubDate'] = date('Y-m-d');
        }
    }

    public function removeCacheIfItemExists()
    {
        if (!empty($this->id)) {
            $this->removeCache();
        }
    }

    public function setAuthor(User $User, $permissions = self::AUTHOR)
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
        return in_array($permissions, array(
            self::AUTHOR,
            self::COAUTHOR,
        ));
    }

    /**
     * Return a list of Users not associated with the Item, so they are "candidates"
     * when we need to add users to it.
     *
     * @return array
     */
    public function notAuthors()
    {
        $this->load();
        $this->Channel->setId($this->data['Item']['channel_id']);

        return array_diff_key(
            Set::combine($this->Channel->members(), '/User/id', '/User/realname'),
            Set::combine($this->authors(), '/User/id', '/User/realname')
        );
    }

    /**
     * Return the list of users associated with this Item.
     *
     * @return array
     */
    public function authors()
    {
        return $this->Behaviors->Ownable->owners(
            $this,
            'User',
            array(
                'fields' => array('User.id', 'User.realname', 'User.email', 'Owner.access'),
            )
        );
    }

    /**
     * Increases reading counter for an item.
     *
     * @param string $id
     */
    public function updateReadingCount()
    {
        $this->read('readings');
        $readings = $this->data['Item']['readings'] + 1;
        $this->clearCache = false;
        $this->saveField('readings', $readings, array('validate' => false, 'callbacks' => false));

        return $readings;
    }

    public function getReadings($id = null)
    {
        $this->setId($id);

        return $this->field('readings');
    }

    /**
     * Finds neighbors for a given item.
     *
     * @param string $id
     */
    public function neighbors()
    {
        $conditions = $this->conditions['published'];
        $conditions[] = 'ABS(DATEDIFF(Item.pubDate, "'.$this->data['Item']['pubDate'].'")) < '.self::NEIGHBORS_MARGIN;
        $result = $this->find('all', array(
            'fields' => array('Item.id', 'Item.title', 'Item.slug'),
            'conditions' => $conditions,
            'contain' => array('Channel'),
            'order' => array('Item.pubDate' => 'desc'),
        ));
        $index = array_search($this->id, Set::extract('/Item/id', $result));
        $prev = $next = null;
        if ($index > 0) {
            $prev = $result[$index - 1];
        }
        if ($index < count($result) - 1) {
            $next = $result[$index + 1];
        }

        return array(
            'prev' => $prev,
            'next' => $next,
        );
    }

    public function labels($channelId = null)
    {
        $Labellable = new LabellableBehavior();
        $options = array(
            'conditions' => array(
                $this->conditions['published'],
                array('Item.channel_id' => $channelId),
            ),
            'joins' => array(
                $this->joinItemChannel(),
            ),
        );

        return $Labellable->findLabels($this, $options);
    }

    public function getBySlugOrFail($slug)
    {
        $this->getBySlug($slug);
        if ($this->isPublishable()) {
            return $this->retrieve();
        }
        throw new \InvalidArgumentException(sprintf('Article %s not found', $slug));
    }

    public function getBySlug($slug)
    {
        $data = $this->findBySlug($slug, array('fields' => 'id'));
        $this->setId($data['Item']['id']);
    }

    public function isPublishable()
    {
        $conditions = $this->conditions['published'];
        $conditions['Item.id'] = $this->id;
        $this->Behaviors->disable('Translate');

        return $this->find(
            'count',
            array(
                'conditions' => $conditions,
                'contain' => 'Channel',
        ));
    }

    public function retrieve($id = null)
    {
        $this->Behaviors->enable('Translate');
        $this->setId($id);
        $this->contain(array(
            'License',
            'MainImage',
            'Image' => array('order' => array('order' => 'ASC', 'name' => 'ASC')),
            'Download' => array('order' => array('order' => 'ASC', 'name' => 'ASC')),
            'Multimedia' => array('order' => array('order' => 'ASC', 'name' => 'ASC')),
        ));
        $this->data = $this->read(null);
        $this->Channel->read(null, $this->data['Item']['channel_id']);
        $this->data['Channel'] = $this->Channel->data['Channel'];
        $this->data['Authors'] = $this->authors();
        $this->data['Label'] = $this->getLabels();
        if (!empty($this->data['MainImage'])) {
            $this->data['MainImage'] = $this->data['MainImage'][0];
        } else {
            $this->data['MainImage'] = array();
        }
    }

    private function getLabels()
    {
        return ClassRegistry::init('Labelled')->find(
            'all',
            array(
                'fields' => array(
                    'Label.title',
                    'Label.id',
                ),
                'conditions' => array(
                    'Labelled.model' => 'Item',
                    'Labelled.foreign_key' => $this->id,
                ),
                'joins' => array(
                    $this->joinLabels(),
                ),
            )
        )
            ;
    }

    public function view($slug)
    {
        try {
            $this->getBySlug($slug);
        } catch (Exception $e) {
            return;
        }
        if ($this->isPublishable()) {
            return $this->retrieve();
        }
        $this->id = false;
    }

    public function credentials()
    {
        return array(
            'guest' => $this->data['Item']['guest'],
            'guestpwd' => $this->data['Item']['guestpwd'],
        );
    }

    public function isRestricted()
    {
        if ($this->data['Item']['guest'] || $this->data['Item']['guestpwd']) {
            return true;
        }

        return false;
    }

    public function isInPrivateChannel()
    {
        $this->Channel->load($this->data['Item']['channel_id']);

        return $this->Channel->data['Channel']['private'];
    }

    public function hasExtras()
    {
        return !empty($this->data['Download']) || !empty($this->data['Multimedia']) || !empty($this->data['Image']);
    }

    public function findFeed($options)
    {
        $this->bindUserModel();
        $options['contain'] = array('User' => array('fields' => array('realname', 'email')), 'Enclosure');
        $options['sticky'] = false;

        return $this->find('catalog', $options);
    }

    /**
     * Bind User Model on the fly through Ownerships.
     */
    private function bindUserModel()
    {
        $this->bindModel(
            array(
                'hasAndBelongsToMany' => array(
                    'User' => array(
                        'className' => 'Access.User',
                        'joinTable' => 'ownerships',
                        'foreignKey' => 'object_id',
                        'associationForeignKey' => 'owner_id',
                        'unique' => true,
                    ),
                ),
            )
        );
    }

    private function joinChannelTitle()
    {
        return array(
            'table' => 'i18n',
            'alias' => 'ChannelTitle',
            'type' => 'left',
            'conditions' => array(
                'ChannelTitle.model' => 'Channel',
                'ChannelTitle.field' => 'title',
                'ChannelTitle.locale' => $this->_getLocale(),
                'ChannelTitle.foreign_key = Item.channel_id',
            ),
        );
    }

    private function joinChannelSlug()
    {
        return array(
            'table' => 'i18n',
            'alias' => 'ChannelSlug',
            'type' => 'left',
            'conditions' => array(
                'ChannelSlug.model' => 'Channel',
                'ChannelSlug.field' => 'slug',
                'ChannelSlug.locale' => $this->_getLocale(),
                'ChannelSlug.foreign_key = Item.channel_id',
            ),
        );
    }

    private function normalizeChannelData(&$item)
    {
        $item['Channel']['title'] = $item['ChannelTitle']['content'];
        $item['Channel']['slug'] = $item['ChannelSlug']['content'];
        unset($item['ChannelTitle'], $item['ChannelSlug']);
    }
}
