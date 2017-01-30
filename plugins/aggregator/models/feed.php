<?php

App::import('Core', 'Xml');
App::import('Core', 'HttpSocket');

class Feed extends AggregatorAppModel {
	var $name = 'Feed';
	var $displayField = 'title';
	var $actsAs = array('Ui.Sluggable' => array('fields' => 'title'));
	
	var $belongsTo = array(
		'Planet' => array(
			'className' => 'Aggregator.Planet',
			'foreignKey' => 'planet_id',
			'dependent' => false
			)
		);
		
	var $hasMany = array(
		'Entry' => array(
			'className' => 'Aggregator.Entry',
			'foreignKey' => 'feed_id',
			'dependent' => true,
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
	
	var $validate = array(
		'feed' => array(
			'isUnique' => array(
				'rule' => 'isUnique', 
				'required' => true, 
				'allowEmpty' => false, 
				'on' => 'create',
				'message' => 'We have this feed yet'
				),
			'isFeed' => array(
				'rule' => array('isFeed'),
				'on' => 'create',
				'message' => 'This URL could not be a feed'
				)
			),
		'planet_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Select a planet',
				'on' => 'edit'
				)
			)
		);
/**
 * Parser class used to parse a given feed
 *
 * @var string
 */
	var $Parser;
/**
 * URL of the feed
 *
 * @var string
 */
	var $url;
/**
 * Store the feed data parsed
 *
 * @var array
 */
	var $feedData;
/**
 * Control the number of redirects allowed to process a feed
 *
 * @var int
 */
	var $maxRedirects = 3;
/**
 * Types of feed managed by this application
 *
 * @var string
 */
	var $managed = array(
		'Rss' => true,
		'Feed' => true
		);


	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_findMethods['dashboard'] = true;
	}

/**
 * Approve a suggested feed setting the approved field to true
 *
 * @param string $id 
 * @return void
 */
	public function approve($id) {
		if (!$this->id && !$id) {
			return false;
		}
		if ($id) {
			$this->id = $id;
		}
		$approved = $this->field('approved');
		if ($approved) {
			return true;
		}
		return $this->saveField('approved', true, false);
	}
	
	
/**
 * Methods to get and process feeds
 *
 */

/**
 * Step 1
 * 
 * Tries to get the content of the feed file. Follows redirects if needed until a
 * maximum.
 *
 * @param string $url The url of a feed
 * @return mixed a string with the feed file contents or false
 */	
	public function getFeed($url, $redirects = 3) {
		if (!$url) {
			return false;
		}
		$Socket = ClassRegistry::init('HttpSocket');
		$Socket->reset(false);
		$response = $Socket->get($url);
		$status = $Socket->response['status']['code'];
		if (in_array($status, array(301, 302))) {
			$redirects--;
			$url = $Socket->response['header']['Location'];
			$Socket->response['status']['code'] = 200;
			if (($redirects > 0) && $url) {
				return $this->getFeed($url, $redirects);
			}
			return false;
		}
		if ($status != 200) {
			return false;
		}
		$this->url = $url;
		$this->redirectCount = 0;
		return $response;
	}

/**
 * Verifies that the URL points to a real feed
 *
 * @param string $value 
 * @return void
 */
	public function check($url) {
		if (!($data = $this->getFeed($url))) {
			return false;
		}
		if($this->toArray($data)) {
			return true;
		}
		return false;
	}

/**
 * Validation method to verify that a url is a real feed, as far as we can parse
 * data to a valid XML feed. Relays on $this->check()
 *
 * @param string $value 
 * @return void
 */
	public function isFeed($value) {
		return $this->check($value['feed']);
	}
/**
 * Step 2
 * 
 * Converts the feed data to array format, removes some data added by the XML parser
 *
 * @param string $feed Feed data
 * @return array The converted array
 */	
	public function toArray($feedData)
	{
		$Xml = ClassRegistry::init('Xml');
		$Xml->load($feedData);
		$data = Set::reverse($Xml);
		unset($Xml);
		$data = array_intersect_key($data, $this->managed);
		return $data;
	}
/**
 * Step 3
 * 
 * Parses the content of a feed file in a format suitable to use with model
 * for a saveAll
 * 
 * Populates $this->data with the result
 *
 * @param string $feed The contents of the feed file as returned by getFeed()
 * @return boolean true on success
 */
	public function parse($feedArray)
	{
		$this->Parser = $this->getParser($feedArray);
		if(empty($this->Parser)) {
			return false;
		}
		$data = $this->Parser->parse();
		unset($this->Parser);
		return $data;
	}
	
/**
 * Get and parse the feed for first time, sets $this->data.
 * For some reason this doesn't work into a direct saveAll with the implicit data. You
 * need to pass the data array to the saveAll.
 *
 * @param string $url 
 * @return void
 */	
	public function load($url) {
		$response = $this->getFeed($url);
		if (!$response) {
			return false;
		}
		
		$data = $this->parse($this->toArray($response));
		
		if (!$data) {
			return false;
		}
		$this->data = Set::merge($data, $this->data);
		return true;
	}
	
	public function beforeSave() {
		if (!$this->id) {
			return $this->load($this->data['Feed']['feed']);
		}
		return true;
	}

/**
 * Fire update of entries in a feed given its id
 *
 * @param string $id 
 * @return void
 */
	public function reload($id = null) {
		if (!$this->id && !$id) {
			return false;
		}
			
		if ($id) {
			$this->id = $id;
		}

		if (!$this->read('*')) {
			return false;
		}
		
		$url = $this->data['Feed']['feed'];
		if (!$this->load($url)) {
			return false;
		}
		$this->Entry->refresh($this);
		return true;
	}

/**
 * Sets the parser we need based on keys found in the feed data
 * 
 * Rss  => Rss2Parser
 * Feed => AtomParser (like blogger)
 *
 * @return void
 */	
	public function getParser(&$feedArray) {
		if (array_key_exists('Rss', $feedArray)) {
			return new Rss2Parser($feedArray['Rss'], $this);
		}
		if (array_key_exists('Feed', $feedArray)) {
			return new AtomParser($feedArray['Feed'], $this);
		}
		return false;
	}

/**
 * Get proposed feeds to the dashboard
 *
 * @param string $state 
 * @param string $query 
 * @param string $results 
 * @return void
 */
	public function _findDashboard($state, $query, $results = array()) {
		if ($state === 'before') {
			$query['fields'] = array(
				'id',
				'title'
				);
			$query['conditions'] =array(
				'approved' => 0
				);
			return $query;
		}
		// Results manipulation
		return $results;
	}
	
	
	
}


/**
* Parser. Abstract class to provide common facilities and interface to Parser subclasses
*/
class Parser
{
	var $data;
	var $Feed;
	
	public function __construct($data, &$Feed = false) {
		$this->data = $data;
		$this->Feed = $Feed;
		
	}
	
	public function feed()
	{
	}
	
	public function entries()
	{
		# code...
	}
	
	public function parse($data = false, $feed_id = false)
	{
		if (!$this->data && !$data) {
			return false;
		}
		if ($data) {
			$this->data = $data;
		}
		$feed = $this->feed();
		$feed['feed'] = $this->Feed->url;
		$feed['planet_id'] = null;
		if (!empty($this->Feed->data['Feed']['planet_id'])) {
			$feed['planet_id'] = $this->Feed->data['Feed']['planet_id'];
		}
		$entries = $this->entries($feed_id);
		return array(
			'Feed' => $feed,
			'Entry' => $entries
			);
	}
}


/**
* Rss Parser. Parses an Rss 2.0 feed and copies data to the internal format of Feed
* model
*/
class Rss2Parser extends Parser
{
	var $channelDefaultKeys = array(
		'title' => '',
		'description' => '',
		'link' => '',
		'language' => '',
		'copyright' => ''
		);
	
	var $entryDefaultKeys = array(
		'title' => '',
		'description' => '',
		'pubDate' => '',
		'link' => '',
		'guid' => '',
		'author' => '',
		'email' => '',
		);
		
	
	
	public function feed()
	{
		$channel = array_merge($this->channelDefaultKeys, $this->data['Channel']);
		$data['title'] = $channel['title'];
		$data['description'] = $channel['description'];
		$data['url'] = $channel['link'];
		$data['language'] = $channel['language'];
		$data['copyright'] = $channel['copyright'];
		$data['updated'] = date('Y-m-d H:i:s');
		return $data;
	}	
	
	public function entries($feed_id) {
		$entries = $this->data['Channel']['Item'];
		if (!is_numeric(key($entries))) {
			$entries = array($entries);
		}
		foreach ($entries as $entry) {
			$e = array_merge($this->entryDefaultKeys, $entry);
			$parts = array();
			if(is_array($e['author'])) {
				$e['author'] = array_shift($e['author']);
			}
			preg_match('/(.+) \(([^)]+)\)/', $e['author'], $parts);
			if (is_array($e['guid'])) {
				if (!empty($e['guid']['isPermaLink'])) {
					$e['guid'] = $e['guid']['value'];
				} else {
					$e['guid'] = $e['link'];
				}
			}
			if (empty($e['title'])) {
				$e['title'] = __d('aggregator', 'Untitled', true);
			}
			$item['title'] = $e['title'];
			$item['content'] = $e['description'];
			$item['pubDate'] = date('Y-m-d H:i:s', strtotime($e['pubDate']));
			$item['url'] = $e['link'];
			$item['guid'] = $e['guid'];
			if (count($parts) >= 3) {
				$item['author'] = $parts[2];
				$item['email'] = $parts[1];
			}
			$item['feed_id'] = $this->Feed->id;
			$item['md5'] = md5($e['title'].$e['description']);
			
			if (!empty($e['Enclosure'])) {
				$item['enclosure_url'] = $e['Enclosure']['url'];
				$item['enclosure_type'] = $e['Enclosure']['type'];
				$item['enclosure_length'] = $e['Enclosure']['length'];
			}
			$data[] = $item;
		}
		return $data;
	}
}

/**
* Atom Parser. 	Parses an Atom feed and copies data to the internal format of Feed
* model
*/
class AtomParser extends Parser
{
	
	var $entryDefaultKeys = array(
		'title' => '',
		'content' => '',
		'published' => '',
		'link' => '',
		'id' => '',
		'Author' => array('name' => '', 'email' => ''),
		);
		
	var $feedDefaultKeys = array(
		'title' => array('value' => ''),
		'description' => array('value' => ''),
		'language' => '',
		'Author' => array('name' => '', 'email' => ''),
		);
	
	

	public function feed() {
		$feed = $this->data;
		$feed = array_merge($this->feedDefaultKeys, $this->data);
		if (is_array($feed['title'])) {
			$data['title'] = $feed['title']['value'];
		} else {
			$data['title'] = $feed['title'];
		}
		if (isset($feed['subtitle'])) {
			if (is_array($feed['subtitle'])) {
				$data['description'] = $feed['subtitle']['value'];
			} else {
				$data['description'] = $feed['subtitle'];
			}
		} else {
			$data['description'] = __d('aggregator', 'No description', true);
		}
		$data['url'] = array_shift(Set::extract($feed, '/Link[rel=alternate]/href'));
		$data['language'] = '';
		$data['copyright'] = $feed['Author']['name'];
		return $data;
	}

	
	public function entries() {
		$entries = $this->data['Entry'];
		if (!is_numeric(key($entries))) {
			$entries = array($entries);
		}

		foreach ($entries as $entry) {
			$e = array_merge($this->entryDefaultKeys, $entry);
			if (is_array($e['title'])) {
				$item['title'] = $e['title']['value'];
			} else {
				$item['title'] = $e['title'];
			}
			if (empty($item['title'])) {
				$item['title'] = __d('aggregator', 'Untitled', true);
			}
			
			if (is_array($e['content'])) {
				$item['content'] = $e['content']['value'];
			} else {
				$item['content'] = $e['content'];
			}
			
			$item['pubDate'] = $e['published'];
			$item['url'] = array_shift(Set::extract($e, '/Link[rel=alternate]/href'));
			$item['guid'] = $e['id'];
			$item['author'] = $e['Author']['name'];
			if (!empty($e['Author']['email'])) {
				$item['email'] = $e['Author']['email'];
			}
			$item['feed_id'] = $this->Feed->id;
			$item['md5'] = md5($item['title'].$item['content']);
			
			$enclosures = Set::extract($e, '/Link[rel=enclosure]');
			if ($enclosures) {
				$enclosure = array_shift($enclosures);
				$item['enclosure_url'] = $enclosure['Link']['href'];
				$item['enclosure_type'] = $enclosure['Link']['type'];
				$item['enclosure_length'] = $enclosure['Link']['length'];
				$item['md5'] = md5($item['title'].$item['content'].
					$item['enclosure_url'].$item['enclosure_length']
					);
			}
			$data[] = $item;
		}
		return $data;
	}

}

/**
* Feed Discoverer
*/
class FeedDiscoverer
{
	public function getPage($url) {
		if (!$url) {
			return false;
		}
		$Socket = ClassRegistry::init('HttpSocket');
		$Socket->reset(false);
		$response = $Socket->get($url);
		$status = $Socket->response['status']['code'];
		if (in_array($status, array(301, 302))) {
			$this->redirecCount++;
			$url = $Socket->response['header']['Location'];
			$Socket->response['status']['code'] = 200;
			if (($this->redirectCount < $this->maxRedirects) && $url) {
				return $this->getPage($url);
			}
			return false;
		}
		if ($status != 200) {
			return false;
		}
		$this->url = $url;
		$this->redirectCount = 0;
		return $response;
	}
	
	public function feed($url) {
		$page = $this->getPage($url);
		$Xml = ClassRegistry::init('Xml');
		$Xml->load($page);
		$data = Set::reverse($Xml);
		$rss = Set::extract($data, '/Html/Head/Link[type=/.*rss.*/]');
		if (!$rss) {
			return false;
		}
		if (count($rss) == 1) {
			return $rss[0]['Link']['href'];
		}
		return Set::extract($rss, '/Link/href');
	}
}




?>