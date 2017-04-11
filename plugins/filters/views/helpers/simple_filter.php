<?php
/**
 * FilterHelper
 * 
 * Wraps FormHelper methods to build Filter forms for index views
 * 
 * Typical usage:
 *
 *	echo $this->SimpleFilter->form();
 *  echo $this->SimpleFilter->equal('textfield');
 *  echo $this->SimpleFilter->boolean('booleanField');
 *  echo $this->SimpleFilter->options('optionsField', array('option' => 'label', 'option2' => 'label2'));
 *  echo $this->SimpleFilter->options('optionsField', array('options' => array('option' => 'label', 'option2' => 'label2')));
 *  echo $this->SimpleFilter->end();
 *
 * @package filters.milhojas
 * @version $Id: filter.php 2998 2013-12-12 16:06:22Z franiglesias $
 * @date $Date: 2013-12-12 17:06:22 +0100 (Thu, 12 Dec 2013) $
 * @revision $Revision: 2998 $
 * $head $HeadURL: http://franiglesias@subversion.assembla.com/svn/milhojas/branches/mh13/plugins/filters/views/helpers/filter.php $
 **/

class SimpleFilterHelper extends AppHelper {

	var $helpers = array('Html', 'Form', 'Ui.FForm');
	
/**
 * Common classes for CSS styling
 *
 * @var string
 */
	var $defaults = array(
		'div' => array('class' => 'small-12 columns')
	);
	
/**
 * Starts the form. Wrapper for Form->create
 *
 * @param string $options
 *
 * @return void
 */
	public function form($options = array())
	{
		$this->FForm->defaults['inputSize'] = 12;
		$this->FForm->defaults['prefixSize'] = 2;
        $view = ClassRegistry::getObject('view');
		$url = array_intersect_key($view->params, array('plugin' => true, 'controller' => true, 'action' => true));
		$url = array_merge($url, $view->params['pass'], $view->params['named']);
		$code = $this->Html->tag('h1', __d('filters', 'Filter by', true), array('class' => 'fi-filter'));
		$code = $this->Html->tag('header', $code);
		$code .= $this->Form->create('Filter', array('url' => $url, 'class' => 'mh-filter-form'));
		$code .= '<div class="row">';
		return $code;
	}

/**
 * Closes Filter Form, automatically adds the submit button and a reset filter button and closes form
 * Wrapper for Form end
 *
 * @param string $options
 *
 * @return string HTML code
 */	
	public function end($options = array())
	{
		$label = __('Filter', true);
		if (!empty($options) && isset($options['label'])) {
			$label = $options['label'];
		}
		$code = $this->Form->submit($label, array('div' => false , 'class' => 'mh-btn-ok right'));
		$code .= $this->Form->submit(__('Reset Filter', true), array(
			'value' => 'reset', 
			'name' => 'FilterReset', 
			'div' => false, 
			'class' => 'mh-btn-cancel'
			)
		);
		$code = $this->Html->div('small-12 columns', $code);
		$code .= '</div>';
		$code .= $this->Form->end();
		return $code;
	}

    /**
     * Creates a contains filter. Matches when the data contains the filter
     *
     * @param string $field
     * @param string $options
     *
     * @return string html
     */
    public function contains($field, $options = array())
    {
        $options['type'] = 'text';
        $options = $this->_setDefaultOptions($field, $options);
        $options = $this->_mergeOptions($options);

        return $this->FForm->input($this->_fieldname($field, 'contains'), $options);

    }

    protected function _setDefaultOptions($field, $options = array())
    {
        if (empty($options['label'])) {
            $options['label'] = $this->_defaultLabel($field);
        }
        if (empty($options['type'])) {
            $options['type'] = 'text';
        }

        return $options;
    }

    protected function _defaultLabel($field)
    {
        list($modelName, $fieldName) = explode('.', $field);

        return Inflector::Humanize($modelName).' '.Inflector::Humanize($fieldName);
    }

    /**
     * Merges options, set labels as placeholders and remove labels to show a compacter view
     *
     * @param string $options
     * @param string $defaults
     *
     * @return array
     * @author Fran Iglesias
     */
    protected function _mergeOptions($options, $defaults = null)
    {
        $options = array_merge($this->defaults, (array)$defaults, (array)$options);
        $options['placeholder'] = $options['label'];
        unset($options['label']);

        return $options;
    }

    /**
     * Builds fieldName, prepending Filter key
     *
     * @param string $fieldName
     *
     * @return string The new field name
     */
    protected function _fieldname($fieldName, $type = 'equal')
    {
        if (strpos($fieldName, '_Filter', 0) === 0) {
            return $fieldName.'.'.$type;
        }
        if (strpos($fieldName, '.') === false) {
            $field = $fieldName;
            $model = ClassRegistry::init('View')->model;
            $fieldName = $model.'.'.$field;
        }

        return '_Filter.'.$fieldName.'.'.$type;
    }

    /**
     * Creates a Filter form input for boolean values. Wrapper for $this->options
     *
     * @param string $field   Model.field required
     * @param string $options Optional array of options to override defaults
     *
     * @return string code for the form field
     */
    public function boolean($field, $options = array())
    {
        $options['options'] = array(
            0 => __('No', true),
            1 => __('Yes', true),
        );

        return $this->options($field, $options);
    }

    /**
     * Creates a filter select input field. Options fields are equal fields.
     * Uses $options['placeholder'] as empty option
     *
     * @param string $field   The field name
     * @param string $options an array with the options for the select menu, or options for input
     *
     * @return string The code for the field
     */
    public function options($field, $options = array())
    {
        $defaults = array(
            'empty' => __('Whatever', true),
            'type' => 'select',
        );
        if (!empty($options) && !isset($options['options'])) {
            $options = array('options' => $options);
        }
        $options = $this->_mergeOptions($options, $defaults);
        $options['empty'] = '-- '.$options['placeholder'].' --';
        $options['dataType'] = 'options';

        return $this->equal($field, $options);
    }

/**
 * Creates an equal filter
 *
 * @param string $field
 * @param string $options
 *
 * @return string HTML
 */
	public function equal($field, $options = array())
	{
		$options = $this->_setDefaultOptions($field, $options);
		$options = $this->_mergeOptions($options);
		$dataType = $this->_dataType($options);
		switch ($dataType) {
			case 'date':
				return $this->FForm->date($this->_fieldname($field, 'equal'), $options);
				break;
			case 'select':
				return $this->FForm->select($this->_fieldname($field, 'equal'), $options);
				break;
			default:
				return $this->FForm->input($this->_fieldname($field, 'equal'), $options);
				break;
		}
	}

    protected function _dataType(&$options)
    {
        if (isset($options['dataType'])) {
            $dataType = $options['dataType'];
            unset($options['dataType']);

            return $dataType;
        }

        return 'text';
    }

    public function date($field, $options = array())
    {
        $options['dataType'] = 'date';

        return $this->equal($field, $options);
    }

    public function dateNot($field, $options = array())
    {
        $options['dataType'] = 'date';

        return $this->different($field, $options);
    }
	
	public function different($field, $options = array())
	{
		$options = $this->_setDefaultOptions($field, $options);
		$options = $this->_mergeOptions($options);
		$dataType = $this->_dataType($options);
		switch ($dataType) {
			case 'date':
				return $this->FForm->date($this->_fieldname($field, 'not'), $options);
				break;
			case 'select':
				return $this->FForm->select($this->_fieldname($field, 'not'), $options);
				break;

			default:
				return $this->FForm->input($this->_fieldname($field, 'not'), $options);
				break;
		}
	}

    public function dateRange($field, $options = array())
	{
        $options['dataType'] = 'date';

        return $this->range($field, $options);
	}


    // public function binary($field, $options = array())
    // {
    // 	if (empty($options['label'])) {
    // 		$options['label'] = $this->_defaultLabel($field);
    // 	}
    // 	$options = $this->_mergeOptions($options);
    // 	return $this->XForm->binary($this->_fieldname($field, 'binary'), $options);
    // }
    //
    // public function days($field, $options = array())
    // {
    // 	if (empty($options['label'])) {
    // 		$options['label'] = $this->_defaultLabel($field);
    // 	}
    // 	$options = $this->_mergeOptions($options);
    // 	return $this->XForm->days($this->_fieldname($field, 'binary'), $options);
    // }
    //
    // public function swap($field, $options = array())
    // {
    // 	$defaults = array(
    // 		'empty' => __('Whatever', true)
    // 	);
    // 	$view = ClassRegistry::init('view');
    // 	if (empty($view->viewVars['filterSwaps'])) {
    // 		return false;
    // 	}
    // 	$swaps = $view->viewVars['filterSwaps'];
    //
    // 	if (!isset($swaps[$field])) {
    // 		return false;
    // 	}
    // 	$menu = array();
    // 	foreach ($swaps[$field] as $value => $settings) {
    // 		$menu[$value] = $settings['label'];
    // 	}
    // 	$options['options'] = $menu;
    // 	if (empty($options['label'])) {
    // 		$options['label'] = $this->_defaultLabel($field);
    // 	}
    // 	$options = $this->_mergeOptions($options, $defaults);
    // 	return $this->FForm->input($this->_fieldname($field), $options);
    // }

/**
 * Creates a dual field to filter by a range of values
 *
 * @param string $field
 * @param string $options
 *
 * @return string html
 */

	public function range($field, $options = array())
	{
		$code = $this->greater($field, $options);
		$code .= $this->less($field, $options);
		return $code;
	}

/**
 * Creates a field to filter values greater than
 *
 * @param string $field
 * @param string $options
 *
 * @return string html
 */
	public function greater($field, $options = array())
	{
		$options = $this->_setDefaultOptions($field, $options);
		$options = $this->_mergeOptions($options);
		$options['placeholder'] = sprintf('From %s', $options['placeholder']);
		$dataType = $this->_dataType($options);
		switch ($dataType) {
			case 'date':
				return $this->FForm->date($this->_fieldname($field, 'from'), $options);
				break;
			case 'select':
				return $this->FForm->select($this->_fieldname($field, 'from'), $options);
				break;

			default:
				return $this->FForm->input($this->_fieldname($field, 'from'), $options);
				break;
		}
	}

    /**
 * Creates a field to filter values less than
 *
     * @param string $field
     * @param string $options
     *
 * @return string html
 */
	public function less($field, $options = array())
	{
		$options = $this->_setDefaultOptions($field, $options);
		$options = $this->_mergeOptions($options);
		$options['placeholder'] = sprintf('To %s', $options['placeholder']);
		$dataType = $this->_dataType($options);
		switch ($dataType) {
			case 'date':
				return $this->FForm->date($this->_fieldname($field, 'to'), $options);
				break;
			case 'select':
				return $this->FForm->select($this->_fieldname($field, 'to'), $options);
				break;
			default:
				return $this->FForm->input($this->_fieldname($field, 'to'), $options);
				break;
		}
	}
	
	public function dateFrom($field, $options = array())
	{
		$options['dataType'] = 'date';
		return $this->greater($field, $options);
	}

    public function dateTo($field, $options = array())
	{
		$options['dataType'] = 'date';
		return $this->less($field, $options);
	}

}
