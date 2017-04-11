<?php
/**
 * CircularHelper
 * 
 * [Short Description]
 *
 * @package circulars.mh13
 * @author Frankie
 * @version $Id$
 * @copyright Fran Iglesias
 **/

App::import('Helper', 'MultilingualPresentationModel');
App::import('Model', 'Circulars.Circular');

class CircularHelper extends MultilingualPresentationModelHelper implements AutoLinkable
{
	var $helpers = array('Html', 'Form');
	var $var = 'circular';
	
	public $statusOptions;
	public $shortStatusOptions;
	public $colorStatuses;
	
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->statusOptions = array(
			Circular::DRAFT => __d('circulars', 'Draft', true),
			Circular::PUBLISHED => __d('circulars', 'Published', true),
			Circular::ARCHIVED => __d('circulars', 'Archived', true),
			Circular::REVOKED => __d('circulars', 'Revoked', true)
 		);
		$this->shortStatusOptions = array(
			Circular::DRAFT => __d('circulars', 'D', true),
			Circular::PUBLISHED => __d('circulars', 'P', true),
			Circular::ARCHIVED => __d('circulars', 'A', true),
			Circular::REVOKED => __d('circulars', 'X', true)
		);
		$this->colorStatuses = array(
			Circular::DRAFT => 'limited',
			Circular::PUBLISHED => 'allowed',
			Circular::ARCHIVED => 'info',
			Circular::REVOKED => 'forbidden'
		);
		
	}
	/**
	 * Called after the controller action is run, but before the view is rendered.
	 *
	 * @access public
	 */
	function beforeRender() {
		parent::beforeRender();
		// $this->Html->script('/circulars/js/translate', array('inline' => false));
		$languages = array(
			__d('circulars', 'spa', true),
			__d('circulars', 'glg', true)
		);
		
	}
	
	public function selfUrl()
	{
		return array(
			'plugin' => 'circulars',
			'controller' => 'circulars',
			'action' => 'view',
			$this->value('id'));
	}
	

	public function responseRequired()
	{
		if (!$this->value('circular_box_id')) {
			return false;
		}
		return __d('circulars', 'This Circular requires a response.', true);
	}
	
	public function translate($field, $options = array()) {
		list($model, $fieldName, $tl) = explode('.', $field);
        $View = ClassRegistry::getObject('view');
		
		$buttonOptionsKeys = array(
			'sl' => true
		);
		$buttonOptions = array(
			'type' => 'button',
			'class' => 'mh-button translate',
			'sl' => null,
			'tl' => $tl
		);
		$buttonOptions = array_merge($buttonOptions, array_intersect_key($options, $buttonOptionsKeys));
		$buttonOptions['sfield'] = Inflector::Classify($model).Inflector::Classify($fieldName).Inflector::Classify($buttonOptions['sl']);
		$buttonOptions['tfield'] = Inflector::Classify($model).Inflector::Classify($fieldName).Inflector::Classify($buttonOptions['tl']);
		
		$label = null;
		if (!empty($options['label'])) {
			$label = $options['label'];
		}
		$type = 'text';
		if (!empty($options['rows'])) {
			$type = 'textarea';
		}
		$options['type'] = $type;
		$options['div'] = array('class' => 'input translate');
		$options['after'] = $this->button(sprintf(__d('circulars', 'Translate from %s', true), __d('circulars', $buttonOptions['sl'], true)), $buttonOptions);
		$code = $this->input($field, $options);
		return $code;
	}
	
	public function platform($lang)
	{
		$this->setLanguage($lang);
		$text = array();
		$text[] = $this->format('title', 'string', '<h1>%s</h1>');
		$text[] = $this->format('content', 'html');
		$text[] = sprintf('<strong>%s</strong>', __d('circulars', 'Remainders', true));
		$text[] = $this->format('extra', 'html');
		$path = $this->format('filename', 'string', 'files/%s');
		$path = Router::url('/', true).$path;
		$text[] = sprintf('<p><a href="%s">Descargar circular: %s</a></p>', $path, $this->value('title'));
  		return implode(chr(13).chr(10), $text);
	}
	
/**
 * Override to support bilingual
 *
 * @param string $model
 * @param string $field
 * @param string $modelID
 *
 * @return void
 * @author Fran Iglesias
 */
	
	function tagIsInvalid($model = null, $field = null, $modelID = null) {
        $view = ClassRegistry::getObject('view');
		$errors = $this->validationErrors;
		$entity = $view->entity();
		if (!empty($entity)) {
			return Set::extract($entity[0].'.'.$entity[1], $errors);
		}
	}
	
	
}
