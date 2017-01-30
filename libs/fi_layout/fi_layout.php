<?php
interface Layout {
	public function order();
	public function body();
	public function render();
	public function usingLayout($layout);
	public function usingTemplate($template);
	public function withTitle($title = false);
	public function withFooter($footer = false);
}

/**
* 
*/
abstract class AbstractLayout implements Layout
{
	var $CollectionPresentationModel;
	var $layout;
	var $template;
	var $title;
	var $footer;
	var $_placeHolders = array(
		'body' => '[[body]]',
		'title' => '[[title]]',
		'footer' => '[[footer]]'
	);
	
	function __construct($CollectionPresentationModel)
	{
		$this->CollectionPresentationModel = $CollectionPresentationModel;
	}
	
	public function setPresentationModel($CollectionPresentationModel)
	{
		$this->CollectionPresentationModel = $CollectionPresentationModel;
	}
	
	public function setTemplate($template, $itemTemplate)
	{
		$this->template = $template;
		$this->itemTemplate = $itemTemplate;
	}

	// Chainable methods
	public function withTitle($title = false)
	{
		$this->title = $title;
		return $this;
	}
	
	public function withFooter($footer = false)
	{
		$this->footer = $footer;
		return $this;
	}
	
	public function usingLayout($layout)
	{
		$this->layout = $layout;
		return $this;
	}
	
	public function usingTemplate($template)
	{
		$this->template = $template;
		return $this;
	}
	
	public function body()
	{
		$result = '';
		$order = $this->order();
		foreach ($order as $item) {
			$this->CollectionPresentationModel->pointer($item);
			$result .= $this->block($this->template);
		}
		return $result;
	}
	
	public function render()
	{
		$layout = $this->block($this->layout);
		$body = $this->body();
		$result = str_replace('[[body]]', $body, $layout);
		$result = str_replace('[[title]]', $this->title, $result);
		return str_replace('[[footer]]', $this->footer, $result);
	}
	
	private function block($element, $options = array())
	{
		$element = $this->element($element, $options);
		$code = $this->CollectionPresentationModel->View->element($element, $options, false);
		if (strpos($code, 'Not Found:') !== FALSE) {
			throw new RuntimeException($element.' not found', 1);
		}

		return $code;
	}
	
	private function element($element, &$options)
	{
		$parts = explode(DS, str_replace('/', DS, $element));
		if (!$parts[0]) {
			array_shift($parts);
			$options['plugin'] = array_shift($parts);
			return implode(DS, $parts);
		}
		return $element;
	}

}

App::import('Lib', 'Singleton');

/**
* 
*/
class LayoutFactory extends Singleton
{
	static $_registry = array();
	
	public static function get($type, $CollectionPresentationModel)
	{
		$Layout = ucfirst($type).'Layout';
		if ($L = self::exists($Layout)) {
			$L->setPresentationModel($CollectionPresentationModel);
			return $L;
		}
		return self::create($Layout, $CollectionPresentationModel);
	}

	/**
	 * Creates a new class and appends it to the registry
	 *
	 * @param string $Layout 
	 * @param string $CPM 
	 * @return the class
	 */
	protected function create($Layout, $CPM)
	{
		App::import('Lib', 'fi_layout/layouts/'.$Layout);
		if (!class_exists($Layout)) {
			$Layout = 'ListLayout';
		}
		$L = new $Layout($CPM);
		self::$_registry[$Layout] = $L;
		return $L;
	}
	/**
	 * Returns registered class
	 *
	 * @param string $type 
	 * @return the class
	 */
	protected function exists($type)
	{
		if (!isset(self::$_registry[$type])) {
			return false;
		}
		return self::$_registry[$type];
	}
	
}


?>