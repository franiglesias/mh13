<?php
App::import('Lib', 'data_provider/ArrayDataProvider');
App::import('Lib', 'data_provider/ModelDataProvider');
App::import('Lib', 'data_provider/ListDataProvider');
App::import('Lib', 'data_provider/CollectionDataProvider');
App::import('Lib', 'data_provider/NullDataProvider');
App::import('Lib', 'SimpleIterator');

class DataProviderFactory
{
	
	public function make(&$dataSet, $model = null)
	{
		if ($this->invalidDataSet($dataSet)) {
			return $this->buildNullDataProvider();
		}
		if ($this->isAssoc($dataSet)) {
			if ($this->isModelArray($dataSet)) {
				return $this->buildModelDataProvider($dataSet, $model);
			}
			return $this->buildArrayDataProvider($dataSet);
		} else {
			if ($this->isModelList($dataSet)) {
				return $this->buildCollectionDataProvider($dataSet, $model);
			}
			return $this->buildListDataProvider($dataSet);
		}
	}
	
	private function invalidDataSet(&$dataSet)
	{
		if (is_null($dataSet) || empty($dataSet)) {
			return true;
		}
	}
	private function buildNullDataProvider()
	{
		return new NullDataProvider();
	}
	
	private function buildArrayDataProvider(&$dataSet)
	{
		return new ArrayDataProvider($dataSet);
	}
	
	private function buildModelDataProvider(&$dataSet, $model)
	{
		$DP = new ModelDataProvider($dataSet);
		if (!$model) {
			$model = key($dataSet);
		}
		$DP->useModel($model);
		return $DP;
	}
	
	private function buildListDataProvider(&$dataSet)
	{
		return new ListDataProvider(new SimpleIterator(), $dataSet);
	}
	
	private function buildCollectionDataProvider(&$dataSet, $model)
	{
		$DP = new CollectionDataProvider(new SimpleIterator(), $dataSet);
		if (!$model) {
			$model = key($dataSet[0]);
		}
		$DP->useModel($model);
		return $DP;
	}
		
	private function isAssoc($array)
	{
		if($this->ifAtLeastOneKeyIsAStringTheArrayIsAssoc($array)) {
			return true;
		}
		return false;
	}
	
	private function isModelArray($array)
	{
		return count(array_filter(array_values($array), 'is_array'));
	}
	
	private function ifAtLeastOneKeyIsAStringTheArrayIsAssoc($array)
	{
		return count(array_filter(array_keys($array), 'is_string'));
	}
	
	
	private function isModelList($array)
	{
		if (!isset($array[0])) {
			return false;
		}
		$key = key($array[0]);
		foreach ($array as $item) {
			if (!is_array($item)) {
				return false;
			}
			if (!is_array($item[$key])) {
				return false;
			}
			if ($key !== key($item)) {
				return false;
			}
		}
		return $key;
	}
	
}


?>