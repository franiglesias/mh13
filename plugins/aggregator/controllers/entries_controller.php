<?php
class EntriesController extends AggregatorAppController {

	var $name = 'Entries';
	
	var $helpers = array('Aggregator.Aggregator');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}

	function index() {
		$this->layout = 'aggregator';
		$this->paginate['Entry']['contain'] = array('Feed.Planet');
		$this->paginate['Entry']['conditions'] = array('Feed.approved' => 1);
		$this->set('entries', $this->paginate('Entry'));
		$planets = $this->Entry->Feed->Planet->find('all', array('order' => array('title' => 'ASC')));
		$this->set(compact('planets'));
		$this->set('title_for_layout', __d('aggregator', 'All aggregated entries', true));
	}
	
	function last($slug = false) {
		$conditions = array();
		if ($slug) {
			$conditions = array(
				'Planet.slug' => $slug
				);
		} 
		$limit = $this->paginate['limit'];
		if (!empty($this->params['requested'])) {
			return $this->Entry->find('planet', compact('conditions', 'limit'));
		}
	}


	function view($id = null) {
		$this->layout = 'aggregator';
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), 'entry'), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$entry =  $this->Entry->find('first', array(
				'conditions' => array('Entry.id' => $id),
				'contain' => 'Feed.Planet'
				)
		);

		$title_for_layout = sprintf(__d('aggregator', '%s by %s', true), $entry['Entry']['title'], $entry['Feed']['title']);
		$this->set(compact('entry', 'title_for_layout'));
	}
	
	function planet($slug = false) {
		if (!$slug) {
			$this->setAction('index');
		}
		$this->paginate['Entry'][0] = 'planet';
		$this->paginate['Entry']['conditions'] = array(
			'Planet.slug' => $slug
			);
		$entries = $this->paginate('Entry');
		$planet = $this->Entry->Feed->Planet->findBySlug($slug);
		if ($this->RequestHandler->prefers('rss')) {
			$channel = $planet['Planet'];
			$channel['docs'] = 'http://blogs.law.harvard.edu/tech/rss';
			$channel['link'] = array(
				'plugin' => 'aggregator',
				'controller' => 'entries',
				'action' => 'planet',
				$slug
				);
			$items = $entries;
			$channelElements = array('docs' => true, 'link' => true, 'description' => true, 'title' => true);
			$channel = array_intersect_key($channel, $channelElements);
			
			$this->set(compact('channel', 'items'));
		} else {
			$this->layout = 'aggregator';
			$feeds = $this->Entry->Feed->find('all', array(
				'conditions' => array(
					'Feed.planet_id' => $planet['Planet']['id'],
					'Feed.approved' => true
					),
				'order' => array('title' => 'ASC')
				)
			);
			
			$this->set(compact('planet', 'entries', 'feeds', 'slug'));
		}
		$title_for_layout = sprintf(__d('aggregator', '%s planet at %s', true), $planet['Planet']['title'], Configure::read('Site.title'));
		$this->set(compact('title_for_layout'));
	}

	function feed($slug = false) {
		$this->layout = 'aggregator';
		if (!$slug) {
			$this->setAction('index');
		}
		$this->paginate['Entry']['contain'] = 'Feed';
		$this->paginate['Entry']['conditions'] = array('Feed.slug' => $slug);
		if (!empty($this->params['requested'])) {
			return $this->Entry->find('all', $this->paginate['Entry']);
		}
		$entries = $this->paginate('Entry');
		$this->Entry->Feed->contain('Planet');
		$feed = $this->Entry->Feed->findBySlug($slug);
		$feeds = $this->Entry->Feed->find('all', array(
			'conditions' => array(
				'Feed.planet_id' => $feed['Feed']['planet_id'], 
				'Feed.id !=' => $feed['Feed']['id'],
				'Feed.approved' => 1
				),
			'order' => array('title' => 'ASC')
			)
		);
		$this->set(compact('feed', 'feeds', 'entries'));
		$title_for_layout = sprintf(__d('aggregator', '%s feed aggregated at %s', true), $feed['Feed']['title'], Configure::read('Site.title'));
		$this->set(compact('title_for_layout'));
	}


}
?>