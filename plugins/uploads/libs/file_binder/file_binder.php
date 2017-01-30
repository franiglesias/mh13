<?php

App::import('Lib', 'Uploads.FileBinderStrategyInterface');
App::import('Lib', 'Uploads.AttachFileBinderStrategy');
App::import('Lib', 'Uploads.InlineFileBinderStrategy');
App::import('Lib', 'Uploads.MoveFileBinderStrategy');
App::import('Lib', 'Uploads.CopyFileBinderStrategy');
/**
* 
*/
class FileBinder
{
	
	private $FileBinderStrategy;
	private $Dispatcher;
	private $Model;
	private $params;
	private $mode;
	
	function __construct(FileDispatcher $Dispatcher, $params)
	{
		$this->Dispatcher =& $Dispatcher;
		$this->params = $params;
		$this->FileBinderStrategy = $this->selectStrategy();
	}
	
	public function getMode()
	{
		return $this->mode;
	}
	
	private function selectStrategy()
	{
		if ($this->isCopy()) {
			$this->mode = 'copy';
			return new CopyFileBinderStrategy($this->params);
		}
		if ($this->isMove()) {
			$this->mode = 'move';
			return new MoveFileBinderStrategy($this->params);
		}
		
		if ($this->isAttach()) {
			$this->mode = 'attach';
			return new AttachFileBinderStrategy($this->params);
		}
		if ($this->isInline()) {
			$this->mode = 'inline';
			return new InlineFileBinderStrategy($this->params);
		}
		throw new RuntimeException('Binder: Incomplete Upload Request. No enough arguments.');
		
	}

	private function isCopy()
	{
		return $this->isMove() && !empty($this->params['copy']);
	}
	private function isMove()
	{
		return !empty($this->params['upload_id']);
	}
	
	private function isAttach()
	{
		return empty($this->params['field']) && $this->mandatoryArgumentsPresent();
	}
	
	private function isInline()
	{
		return !empty($this->params['field']) && $this->mandatoryArgumentsPresent();
	}
	
	private function mandatoryArgumentsPresent()
	{
		return !empty($this->params['class']) && !empty($this->params['fk']);
	}
	
	public function bind(DispatchedFileInterface $File)
	{
		return $this->FileBinderStrategy->bind($File, $this->Dispatcher);
	}
	
}


?>