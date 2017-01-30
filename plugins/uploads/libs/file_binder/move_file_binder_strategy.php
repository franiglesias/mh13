<?php

App::import('Lib', 'Uploads.FileBinderStrategyInterface');
App::import('Lib', 'Uploads.abstracts/AbstractFileBinderStrategy');

/**
* 
*/
class MoveFileBinderStrategy extends AbstractFileBinderStrategy implements FileBinderStrategyInterface
{
	private $Upload;

	public function __construct($params)
	{
		$this->Upload = ClassRegistry::getObject('Upload');
		$this->params = $params;
	}
	
	public function bind(UploadedFileInterface $File, FileDispatcherInterface $Dispatcher)
	{
		$data = $this->Upload->read(null, $this->params['upload_id']);
		
		$this->params['class'] = $data['Upload']['model'];
		$this->params['fk'] = $data['Upload']['foreign_key'];
		$this->prepareSubrouting($Dispatcher);
		
		$Dispatcher->dispatch($File);
		
		$this->Upload->set(array(
			'path' => $File->getPath(),
			'fullpath' => $File->getFullPath(),
		));
		if ($this->Upload->save()) {
			return $File;
		}
		throw new RuntimeException('Uploaded File can not be associated to an Upload Record');
	}
	
}


?>