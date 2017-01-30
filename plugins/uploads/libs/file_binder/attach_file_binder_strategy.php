<?php

App::import('Lib', 'Uploads.FileBinderStrategyInterface');
App::import('Lib', 'Uploads.abstracts/AbstractFileBinderStrategy');

/**
* 
*/
class AttachFileBinderStrategy extends AbstractFileBinderStrategy implements FileBinderStrategyInterface
{
	private $Upload;
	public function __construct($params)
	{
		$this->Upload = ClassRegistry::getObject('Upload');
		$this->params = $params;
	}
	
	public function bind(UploadedFileInterface $File, FileDispatcherInterface $Dispatcher)
	{
		$order = $this->Upload->maxOrder($this->params['class'], $this->params['fk']) + 1;
		$data = array(
			'model' => $this->params['class'],
			'foreign_key' => $this->params['fk'],
			'enclosure' => !empty($this->params['enclosure']),
			'order' => $order
		);
		// Reset previous enclosure
		if (!empty($this->params['enclosure'])) {
			$this->Upload->updateAll(array('enclosure' => 0), array(
				'model' => $this->params['class'],
				'foreign_key' => $this->params['fk'],
			));
		}
		$this->prepareSubrouting($Dispatcher);
		$Dispatcher->dispatch($File);
		if ($this->Upload->createFromFile($File->getFullPath(), $data)) {
			return $File;
		}
		throw new RuntimeException('Uploaded File can not be associated to an Upload Record');
	}
}


?>