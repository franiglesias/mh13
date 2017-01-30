<?php

App::import('Lib', 'Uploads.FileBinderStrategyInterface');
App::import('Lib', 'Uploads.abstracts/AbstractFileBinderStrategy');

class InlineFileBinderStrategy extends AbstractFileBinderStrategy implements FileBinderStrategyInterface
{
	
	public function __construct($params)
	{
		// $this->Upload = ClassRegistry::getObject('Upload');
		$this->params = $params;
	}
	
	
	public function bind(UploadedFileInterface $File, FileDispatcherInterface $Dispatcher)
	{
		$this->prepareSubrouting($Dispatcher);
		$Dispatcher->dispatch($File, $this->getUpableSettings());
	}
}


?>