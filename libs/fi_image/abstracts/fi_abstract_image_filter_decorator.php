<?php

App::import('Lib', 'fi_image/abstracts/FiAbstractImageDecorator');


abstract class FiAbstractImageFilterDecorator extends FiAbstractImageDecorator
{
	protected $intensity;
	protected $maxIntensity = 255;
	
	protected function normalize($intensity)
	{
		return floor($intensity * $this->maxIntensity / 100);
	}
	
	public function write()
	{
		$this->apply();
		$this->Image->write();
	}
}



?>