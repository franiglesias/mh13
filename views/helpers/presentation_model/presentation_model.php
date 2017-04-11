<?php
/**
 * PresentationModelHelper
 * 
 * Implements an abstract Presentation Model pattern for structured data
 * Offers methods to output data
 * Should be extended in specialized subclasses
 * 
 * @package helpers.views.mh13
 * @author Fran Iglesias
 * @version $Id$
 **/
App::import('Lib', 'data_provider/DataProviderFactory');
/**
 * A Presentation Model is a ViewHelper that encapsulates presentation logic related to a model
 *
 * @package helpers.mh13
 * @author Fran Iglesias
 */
interface PresentationModel{
	// Binds DataProvider with a source var
	public function bind(&$source);
	// Use a model with data provider
	public function useModel($model);
	// Associate a DataProvider with this Presentation Model
	public function setView(View $View);
	public function setDataProvider(DataProvider &$DataProvider);
	public function setDataProviderFactory(DataProviderFactory $DataProviderFactory);
	
}


abstract class PresentationModelHelper 
	extends AppHelper 
	implements PresentationModel {

	var $View = null;
	var $DataProviderFactory = null;

	var $DataProvider = null;
	var $var = null;
	
	var $helpers = false;
	var $model = null;
	
	public function __construct()
	{
	}
	
	# Inteface implementation
	
	public function bind(&$source)
	{
		if (!$this->DataProvider) {
			$this->DataProvider = $this->DataProviderFactory->make($source, $this->model);
			return $this;
		}
		$this->DataProvider->bind($source);
		return $this;
	}
	
	public function useModel($model)
	{
		$this->model = $model;
		if (!$this->DataProvider) {
			return $this;
		}
		$this->DataProvider->useModel($model);
		return $this;
	}

	public function setDataProvider(DataProvider &$DataProvider)
	{
        $this->DataProvider = $DataProvider;
	}

	
	# Dependency Injection
	
	public function setView(View $View)
	{
		$this->View = $View;
	}
	
	public function setDataProviderFactory(DataProviderFactory $DataProviderFactory)
	{
		$this->DataProviderFactory = $DataProviderFactory;
	}
	
	# CakePHP Helper autoinit
	
	public function beforeRender()
	{
		$this->autoInitDataProvider();
	}
	
	private function autoInitDataProvider()
	{
		$this->View = ClassRegistry::getObject('View');
		$this->DataProviderFactory = ClassRegistry::init('DataProviderFactory');
		if (!$this->varExists()) {
			return;
		}
		$this->DataProvider = $this->DataProviderFactory->make($this->View->viewVars[$this->var]);
	}

	private function varExists()
	{
		if (!$this->var) {
			return;
		}
		return array_key_exists($this->var, $this->View->viewVars);
	}





	# Test methods
	
	public function getDataSet()
	{
		return $this->DataProvider->dataSet();
	}
	
	public function &source()
	{
		return $this->DataProvider->source();
	}
	
	public function isEmpty()
	{
		return $this->DataProvider->isEmpty();
	}

	# Utility methods

	public function cacheKey($vars = array())
	{
		$base = $this->model;
		foreach ($vars as $var) {
			if ($value = $this->View->getVar($var)) {
				$base .= '_'.$value;
			}
		}
		return $base;
	}
	public function element($element, $options = array(), $helpers = false)
	{
		$element = str_replace('/', DS, $element);
        $parts = CakeString::tokenize($element, DS);
		$nocache = false;
		if (isset($options['loadHelpers'])) {
			$helpers = $options['loadHelpers'];
			unset($options['loadHelpers']);
		}
		if (isset($options['cache']) && $options['cache'] == 'no') {
			unset($options['cache']);
			$nocache = true;
		}
		$plugin = '';
		if (!$parts[0]) {
			$plugin = $parts[1];
			$element = substr($element, strpos($element, DS, 1)+1);
			$options['plugin'] = $plugin;
		}
		return $this->View->element($element, $options, $helpers);
	}
	

}	

?>
