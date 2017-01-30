<?php

App::import('Lib', 'Access.AccessResource');

class UrlResource implements AccessResource
{
	private $url;
	private $parts = array(
		'plugin' => true,
		'controller' => true,
		'action' => true
		);
	
	public function __construct($urlData)
	{
		if (is_array($urlData)) {
			$this->constructFromArray($urlData);
		} else {
			$this->constructFromString($urlData);
		}
	}
	
	private function constructFromArray($urlData)
	{
		$this->url = array_intersect_key($urlData, $this->parts);
	}
	
	private function constructFromString($urlData)
	{
		$parts = explode(DS, substr($urlData, 1));
		if (count($parts) == 2) {
			array_unshift($parts, false);
		}
		list($plugin, $controller, $action) = $parts;
		$this->url = compact('plugin', 'controller', 'action');
	}
	
	public function value()
	{
		$string = DS.$this->url['controller'].DS.$this->url['action'];
		if (!empty($this->url['plugin'])) {
			$string = DS.$this->url['plugin'].$string;
		}
		return $string;
	}
	
	public function pattern()
	{
		return $this->url;
	}
}
	

?>