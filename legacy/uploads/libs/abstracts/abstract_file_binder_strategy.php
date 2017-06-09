<?php

class AbstractFileBinderStrategy
{
	protected $params;
	
	protected function getUpableSettings()
	{
		$class = $this->params['class'];
		if (!empty($this->params['plugin'])) {
			$class = $this->params['plugin'].'.'.$class;
		}
		if (empty($this->params['field'])) {
			$this->params['field'] = false;
		}
		App::import('Model', $class);
		return ClassRegistry::init($this->params['class'])->uploadSettings($this->params['field']);
	}
	
	protected function prepareSubrouting(FileDispatcher $Dispatcher)
	{
		$Dispatcher->addSubRoute($this->params['class']);
		$Dispatcher->addSubRoute($this->params['fk']);
		if (!empty($this->params['field'])) {
			$Dispatcher->addSubRoute($this->params['field']);
		}
	}
}


?>