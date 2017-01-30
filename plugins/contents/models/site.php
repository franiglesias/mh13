<?php
/**
 * A Site is a model to aggregate channels based on shared tags. You could group the same
 * channels in different sites.
 *
 * @package contents.milhojas
 */

class Site extends ContentsAppModel {
	var $name = 'Site';

	var $displayField = 'title';
	
	var $hasAndBelongsToMany = array(
		'Channel' => array(
			'className' => 'Contents.Channel'
		)
	);

	var $actsAs = array(
		'Translate' => array(
			'title',
			'description'
			),
		'Ui.Sluggable' => array(
			'slug' => 'key'
			)
		);
	
/* Install methods. Use with caution. Will delete all Sites */ 

/**
 * First install. Delete all existing sites and creates a new one, with a default
 * Tag to allow aggregate an initial Channel
 *
 * @return void
 */

	public function install() {
		$this->deleteAll('1=1');
		return $this->createDefaultSite();
	}

/**
 * Creates a default Site based on global Configuration
 *
 * @return void
 */
	
	function createDefaultSite() 
	{
		$data = array(
			'Site' => array(
				'title' => Configure::read('Site.title'),
				'description' => Configure::read('Site.description'),
				'key' => strtolower(Inflector::slug(Configure::read('Site.title'), '_')),
			)
		);
		$this->create();
		if ($this->save($data, array('validates' => false))) {
			return $data['Site']['key'];
		}
		return false;
	}
	
	
/**
 * Retrieves channels associated with this Site
 *
 * @param string $id 
 * @return void
 * @author Fran Iglesias
 */
	public function getChannels($id = false)
	{
		$this->setId($id);
		$tag = $this->field('tag');
		$theChannelsIdsList = ClassRegistry::init('Contents.Channel')->getByTag($tag);
		$result = ClassRegistry::init('Contents.Channel')->find('all', array(
			'fields' => array(
				'id', 'title', 'slug', 'description'
			),
			'conditions' => array(
				'Channel.id' => $theChannelsIdsList
			),
			'order' => array(
				'I18n__title.content' => 'asc'
			)
		));
		return $result;
	}
	
	public function getChannelsIds($key)
	{
		// Get the Site by its key
		$data = $this->find('first', array(
			'fields' => 'id',
			'conditions' => array('Site.key' => $key),
			'contain' => array('Channel.id')
		));
		return Set::extract('/Channel/id', $data);
	}
	
	public function getByKey($key)
	{
		$this->data = $this->find('first', array('conditions' => array('Site.key' => $key)));
		$channels = $this->Channel->find('all', array(
			'fields' => array('Channel.title', 'Channel.id', 'Channel.slug'),
			'conditions' => array('Channel.id' => $this->getChannelsIds($key)),
			'order' => array(
				'I18n__title.content' => 'asc'
			)
		));
		$this->data['Channel'] = Set::extract('/Channel/.', $channels);
		return $this->data;
	}

}
?>