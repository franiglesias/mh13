<?php
/**
 * PageHelper
 * 
 * Sort of Presentation Model pattern for a Page
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Colegio Miralba
 **/

class PageHelper extends AppHelper {
	
	var $helpers = array('Html', 'Paginator');
	var $View = false;
	
	public function __construct($options = array())
	{
		parent::__construct($options);
        $this->View = ClassRegistry::getObject('View');
	}
	/**
	 * Sets the title for the page and sends it to the layout
	 *
     * @param string $title
     *
	 * @return string $title
	 */
	public function title($title)
	{
		$this->View->set('title_for_layout', strip_tags($title));
		return $title;
	}
	
	public function browserTitle($title)
	{
		$this->View->set('title_for_layout', strip_tags($title));
	}

	/**
	 * Detects the preview var in the View and shows the preview ribbon
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function isPreview()
	{
		if (!$this->View->getVar('preview')) {
			return false;
		}
		return $this->Html->tag('aside', __d('contents', 'Preview', true), 'mh-preview-ribbon');
	}
	
	/**
	 * Writes a block using an element
	 *
	 * @param string $element /plugin/folder/element notation
     * @param string $options
     *
	 * @return HTML code generated
	 */
	public function block($element, $options = array())
	{
		$element = $this->element($element, $options);
		$code = $this->View->element($element, $options, $this->loadHelpers($options));
		
		if (strpos($code, 'Not Found:') !== FALSE) {
			throw new RuntimeException($element.' not found', 1);
		}

		if ($this->noCache($options)) {
			$code = '<cake:nocache>'.$code.'</cake:nocache>';
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
	
		private function loadHelpers(&$options)
		{
			if (empty($options['loadHelpers'])) {
				return false;
			}
			$response = $options['loadHelpers'];
			unset($options['loadHelpers']);
			return $response;
		}

    private function noCache(&$options)
    {
        if (isset($options['cache']) && $options['cache'] == 'no') {
            return true;
        }

        return false;
    }
	
	public function paginator($paginator = 'mh-mini-paginator')
	{
		return $this->View->element('paginators/'.$paginator);
	}
	
}
