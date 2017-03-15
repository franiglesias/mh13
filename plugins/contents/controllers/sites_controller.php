<?php
class SitesController extends ContentsAppController {

	var $name = 'Sites';
	var $layout = 'backend';
	var $components = array('Filters.SimpleFilters', 'Ui.Ui');
	var $helpers = array('Contents.Site', 'Contents.Channel', 'Contents.Channels');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array('view', 'menu', 'fullMenu', 'all'));
	}
		
	function index() {
		
		$this->Site->recursive = 0;
		$this->set('sites', $this->paginate());
	}

	function view($key = false) {
		if (!$key) {
            $this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('contents', 'site', true)), 'alert');
			$this->redirect('/');
		}
		$site = $this->Site->getByKey($key);
		$this->setTheme($site);
		$this->setLayout($site);
		$this->set('site', $site);

        return $this->render(
            'plugins/contents/sites/view.twig',
            ['site' => $site['Site'], 'channels' => $site['Channel']]
        );
	}
	
	private function setTheme(&$site)
	{
		if (!empty($site['Site']['theme'])) {
			$this->theme = $site['Site']['theme'];
		}
	}
	private function setLayout(&$site)
	{
		$this->layout = 'site';
		if (!empty($site['Site']['layout'])) {
			$this->layout = $site['Site']['layout'];
		}
	}

	function add() {
		$this->Site->create();
		$this->Site->init();
		$this->Site->save(null, false);
		
		$this->setAction('edit', $this->Site->getID());
	}

	function edit($id = null) {
		
		if (!empty($this->data)) { // 2nd pass
			if (!$id) { // Create a model
				$this->Site->create();
			}
			// Try to save data, if it fails, retry
			if ($this->Site->save($this->data)) {
                $this->Session->setFlash(__('Changes saved to Site', true), 'success');
				$this->xredirect();
			} else {
                $this->Session->setFlash(__('Site couldn\'t be saved', true), 'warning');
			}
		}

		if(empty($this->data)) { // 1st pass
			if ($id) {
				$this->Site->contain('Channel');
				if (!($this->data = $this->Site->find('first', array('conditions' => array('Site.id' => $id))))) {
                    $this->Session->setFlash(__('Invalid Site', true), 'alert');
					$this->xredirect(); // forget stored referer and redirect
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		
		// Render, prepare other data if needed	
		
		$theme = false;
		if (isset($this->data['Site']['theme'])) {
			$theme = $this->data['Site']['theme'];
		}
		$themes   = $this->Ui->themes();
		$layouts  = $this->Ui->layouts($theme, 'site');
		$channels = $this->Site->Channel->find('list');
		$this->set(compact('layouts', 'themes', 'channels'));
		
		
	}

/**
 * A plain list of channels
 *
 * @return void
 */	
	public function menu()
	{
		$sites = $this->Site->find('all', array('order' => array('Site.key')));
		if (!empty($this->params['requested'])) {
			return $sites;
		}
	}
	

}
?>