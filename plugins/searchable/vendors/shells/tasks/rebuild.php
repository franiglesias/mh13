<?php

App::import('Vendor', 'AppShell');
App::import('Model', 'Searchable.Sindex');
/**
* 
*/
class RebuildTask extends AppShell
{
	var $uses = array('Sindex');
	
	function execute()
	{
		$modelName = $this->in('Provide a Model name ([Plugin.]Model)');
		if (strpos($modelName, '.') === 0) {
			$plugin = false;
			$className = $modelName;
		} else {
			list($plugin, $className) = explode('.', $modelName);
		}
		App::import('Model', $modelName);
		$Model = ClassRegistry::init($className);
		if (!$Model->Behaviors->attached('Searchable')) {
			$this->error('Model '.$modelName.' is not Searchable');
		}

		$this->Sindex->deleteAll(array('model' => $Model->alias));
		$records = $Model->find('index');
		$total = count($records);
		$counter = 0;
		$this->out(sprintf('%s records to index.', $total));
		foreach ($records as $record) {
			$counter++;
			$data = $Model->computeIndex($record);
			$this->Sindex->create();
			$this->Sindex->save($data);
			$this->out(sprintf('Indexed %s of %s.', $counter, $total));
		}
		$this->out('Index Rebuilt.');
		$this->hr();
	}
}

?>