<?php

App::import('Helper', 'presentation_model/PresentationModel');
App::import('Lib', 'Batch');
App::import('Lib', 'data_provider/CollectionDataProvider');
App::import('Lib', 'data_provider/ListDataProvider');

class CollectionPresentationModelHelper extends PresentationModelHelper
{
	var $Single = null;
	
	public function attach(SinglePresentationModelHelper $SingleHelper)
	{
		$this->Single = $SingleHelper;
		$this->Single->setView($this->View);
		$this->Single->setDataProviderFactory($this->DataProviderFactory);
		$this->firstSync();
	}
	
	# Iterator like methods
	
	public function pointer($newPointer = null)
	{
		$this->DataProvider->pointer($newPointer);
		$this->sync();
		return $this->DataProvider->pointer();
	}

	public function count()
	{
		return $this->DataProvider->count();
	}

	public function iteration()
	{
		return $this->DataProvider->pointer() + 1;
	}
	
	public function rewind()
	{
		$this->DataProvider->rewind();
	}
	
	
	public function hasNext()
	{
		return $this->DataProvider->hasNext();
	}

	public function next()
	{
		$this->DataProvider->next();
		$this->sync();
	}
	
	# Utility methods
	
	/**
	 * Synchronize Single Helper for first time, enforcing creation of DataProvider
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	private function firstSync()
	{
		if ($this->count()) {
			$this->pointer(0);
		}
		$this->rewind();
	}
	/**
	 * Synchronize Single Helper binding to the current Collection item
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	private function sync()
	{
		$this->Single->bind($this->DataProvider->current());
	}
	
}



?>