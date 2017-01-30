<?php

App::import('Vendor', 'AppShell');
App::import('Model', 'Contents.Channel');

class InstallContentsTask extends AppShell
{
	public function execute()
	{
		$this->out('Installing Access System');
		$this->hr();
		$this->createDefaultChannel();
	}
	
	private function createDefaultChannel()
	{
		$this->out('Creating Default Channel based on Site Configuration.');
		$this->out();
		
		$Channel = ClassRegistry::init('Channel');
		$Channel->Behaviors->disable('Uploadable');
		$data = array(
			'title' => Configure::read('Site.title'),
			'slug' => Inflector::slug(Configure::read('Site.title'), '_'),
			'tagline' => Configure::read('Site.tagline'),
			'description' => Configure::read('Site.description'),
			'icon' => Configure::read('Site.icon'),
			'active' => 1
		);
		foreach ($data as $key => $value) {
			$this->out(sprintf('%s:  %s', $key, $value));
		}
		$Channel->create();
		$Channel->set($data);
		if (!$Channel->save(null, array('validates' => false, 'callback' => false))) {
			return false;
		}
		return $Channel->getInsertID();
	}
}

?>