<?php
/**
* Description
*/
class FiImageEffectsFactory
{
	
	function __construct()
	{
			
	}

	public function make(FiImageInterface $Image, $filters)
	{
		
		foreach ($filters as $filter => $parameters) {
			App::import('Lib', 'fi_image/effects/'.$filter);
			$provided = array_merge(array($Image), array_intersect_key($parameters, $this->needParameters($filter)));
			$Image = $this->getFilterInstance($filter, $provided);
		}
		return $Image;
	}

	protected function getFilterInstance($filter, $parameters)
	{
		$reflector = new ReflectionClass($filter);
		return $reflector->newInstanceArgs($parameters);
	}
	
	protected function needParameters($filter)
	{
		$reflector = new ReflectionClass($filter);
		$result = array();
		foreach ($reflector->getConstructor()->getParameters() as $param) {
			if (!$param->getClass()) {
				$result[$param->getName()] = 'value';
				continue;
			}
			$result[$param->getName()] = $param->getClass()->getName();
		}
		return $result;
	}
	
	
}
?>