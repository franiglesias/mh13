<?php
/**
 * FFormHelper
 * 
 * A Helper to build Forms using Foundation Framework. It's a wrapper for the standard FormHelper
 *
 * @package ui.plugins.mh13
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class FFormHelper extends AppHelper {

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Form', 'Session', 'Js', 'Ui.XHtml', 'Uploads.Upload');
	
	var $defaults = array(
		
		// Basic options
		
		'type' => 'text', // Basic type of input file
		'class' => false, // A class for the input
		'clearable' => false, // (boolean) adds a button to clear the field
		'wrapPostfix' => true, // (booelan) Wraps postfix in span, false for buttons

		// Foundation Framework options
		
		'labelPosition' => 'top', // (top | inline | standar)
		'labelSize' => 3, // size expressed in foundation grid columns
		'grid' => 12, // number of columns for the grid
		'corners' => false, // false, radius, round - Styling for combined fields
		'prefix' => false, // false, text, link-button
		'postfix' => false, // false, text, link-button
		'placeholder' => false, // A placeholder
		'prefixSize' => 1,
		'postfixSize' => 1,
		'inputSize' => 12,
		
		// Custom options
		'help' => false, // A text for help
		
		// CakePHP Form Helper
		'label' => false,
		'div' => array('class' => 'small-12 columns'), // If string, div is considered as class
		'error' => false,
		'empty' => false,
		'before' => false,
		'after' => false,
		'between' => false,
		'options' => false,
		'format' => false,
	); 
	
	var $formHelperOptions = array(
		'after' => true,
		'before' => true,
		'between' => true,
		'class' => true,
		'cols' => true,
		'dateFormat' => true,
		'default' => true,
		'div' => true,
		'empty' => true,
		'error' => true,
		'format' => true,
		'hiddenField' => true,
		'id' => true,
		'interval' => true,
		'label' => true,
		'legend' => true,
		'maxLenght' => true,
		'maxYear' => true,
		'minYear' => true,
		'multiple' => true,
		'options' => true,
		'rows' => true,
		'selected' => true,
		'separator' => true,
		'timeFormat' => true,
		'type' => true,
		
		'placeholder' => true
		
		
	);

	/**
	 * Called after the controller action is run, but before the view is rendered.
	 *
	 * @access public
	 */
	function beforeRender() {
		parent::beforeRender();
		$this->Html->script('/ui/js/jquery-ui', array('inline' => false));
		$this->Html->script('/ui/js/jquery.ui.datepicker-es', array('inline' => false));
		$this->Html->script('/ui/js/jquery-ui.multidatespicker', array('inline' => false));
		$this->Html->css('/ui/css/jquery-ui', null, array('inline' => false));
		// Other scripts go in the app.js file
	}

	/**
	 * After render callback.  afterRender is called after the view file is rendered
	 * but before the layout has been rendered.
	 *
	 * @access public
	 */
	function afterRender() {
	}

	/**
	 * Before layout callback.  beforeLayout is called before the layout is rendered.
	 *
	 * @access public
	 */
	function beforeLayout() {
	}

	/**
	 * After layout callback.  afterLayout is called after the layout has rendered.
	 *
	 * @access public
	 */
	function afterLayout() {
	}
	
	public function ajaxAdd($url, $options = array()) {
		if (empty($options['parentModel'])) {
			$options['parentModel'] = $this->model();
		}
		
		if (empty($options['class'])) {
			$options['class'] = 'mh-btn-ok right';
		}
		
		$childModel = str_replace('_', '-', Inflector::underscore($options['childModel']));
		$buttonId = 'add-'.$childModel;

		if (empty($options['busy-indicator'])) {
			$options['busy-indicator'] = '#mh-'.strtolower(Inflector::pluralize($childModel)).'-busy-indicator';
		}

		if (empty($options['update'])) {
			// $options['update'] = '#'.$childModel.'-form';
			$options['update'] = '#'.$childModel.'-form';
		}
		if (empty($options['focus'])) {
			$model = ClassRegistry::getObject($options['childModel']);
			$options['focus'] = $model->alias.'.'.$model->displayField;
		}
		
		$keys = $this->Form->_initInputField($options['focus'], array('secure' => false));
		$options['focus'] = $keys['id'];
		
		if (empty($options['label'])) {
			$options['label'] = sprintf(__('Add a new %s to this %s', true), $options['childModel'], $options['parentModel']);
		}

		$code = $this->Form->button(
			$options['label'],
			array(
				'type' => 'button',
				'name' => 'add',
				'id' => $buttonId,
				'class' => 'mh-ajax-add '.$options['class'],
				'mh-update' => $options['update'],
				'mh-indicator' => $options['busy-indicator'],
				'mh-url' => $url
			)
		);
		return $code;
	}

	public function ajaxSend($url, $options = array()) {
		if (empty($options['model'])) {
			$options['model'] = $this->model();
		}
		
		if (empty($options['label'])) {
			$options['label'] = sprintf(__('Submit %s', true), $options['model']);
		}
		
		if (empty($options['class'])) {
			$options['class'] = 'mh-btn-ok right';
		}
		
		$modelId = str_replace('_', '-', Inflector::underscore($options['model']));
		
		if (empty($options['close'])) {
			$options['close'] = '#'.$modelId.'-form';
		}
		// URL deprecated
		$url = $this->mergePagination($url);
		$url = Router::url($url, true);
				
		$plModel = Inflector::pluralize($options['model']);
		$plModel = Inflector::underscore($plModel);
		$plModel = str_replace('_', '-', $plModel);
		$plModel = strtolower($plModel);
		
		if (empty($options['busy-indicator'])) {
			$options['busy-indicator'] = '#mh-'.$plModel.'-busy-indicator';
		}
		
		
		if (empty($options['update'])) {
			$options['update'] = '#'.$plModel.'-list';
		}
		
		$buttonId = 'send-'.$modelId;
		
		$complete = "$('{$options['close']}').foundation('reveal', 'close');";

		$code = $this->Form->button(
			$options['label'],
			array(
				'type' => 'submit',
				'name' => 'send',
				'id' => $buttonId,
				'class' => 'mh-ajax-send '.$options['class'],
				'mh-update' => $options['update'],
				'mh-close' => $options['close'],
				'mh-indicator' => $options['busy-indicator'],
				'mh-url' => Router::url()
			)
		);
		
		$code = $this->Html->link(
			__('Discard changes', true),
			'javascript:void(0)',
			array(
				'onclick' => $complete,
				'class' => 'mh-btn-back'
			)
		).$code;
		return $code;
	}

    /**
     * Merges pagination data to build complete url to return to the right page
     *
     * @param string $url
     *
     * @return void
     */
    public function mergePagination($url)
    {
        $extract = array('page' => true, 'sort' => true, 'direction' => true);
        $pagination = array_intersect_key($this->params['named'], $extract);
        $url = array_merge($url, $pagination);

        return $url;
    }

    /**
     * Wrapper for FormHelper->end()
     *
     * @param array $options
     *
     * @return string
     */

    public function end($options = array())
    {

        if (is_string($options)) {
            $options = array('returnTo' => $options);
        }
        // $key = '_App.referer.'.$this->params['plugin'].'.'.$this->params['controller'].'.'.$this->params['action'];
        // $returnTo = $this->Session->read($key);
        $returnTo = $this->Form->value('_App.referer');
        if (isset($options['returnTo'])) {
            $returnTo = $options['returnTo'];
        }

        $defaults = array(
            'discard' => __('Discard changes', true),
            'saveAndWork' => __('Save and Keep Working', true),
            'saveAndDone' => __('Save and Done', true),
        );
        $options = array_merge($defaults, $options);
        $code = '';
        $left = '';
        $right = '';
        // Discard changes
        if ($options['discard']) {
            $left = $this->_endDiscardChanges($options['discard'], $returnTo);
        }
        // Save and done
        if ($options['saveAndDone']) {
            $right = $this->_endSaveAndDone($options['saveAndDone']);
        }
        // Save and keep working
        if ($options['saveAndWork']) {
            $right .= $this->_endSaveAndWork($options['saveAndWork']);
        }

        $code = $this->Form->input('_App.referer', array('type' => 'hidden'));

        $code .= $this->Html->div('medium-5 columns', $left);
        $code .= $this->Html->div('medium-7 columns', $right);
        $code = $this->Html->div('row', $code);
        $code .= $this->Form->end();

        return $code;
    }

    private function _endDiscardChanges($label, $destination)
    {
        $button = $this->Html->link(
            $label,
            $destination,
            array('class' => 'mh-btn-cancel left')
        );

        return $button;
    }

    private function _endSaveAndDone($label)
    {
        $button = $this->Form->submit(
            $label,
            array(
                'name' => 'done',
                'value' => true,
                'class' => 'mh-btn-save right',
                'div' => false,
            )
        );

        return $button;
    }

    private function _endSaveAndWork($label)
    {
        $button = $this->Form->submit(
            $label,
            array(
                'name' => 'save_and_work',
                'class' => 'mh-btn-save right',
                'value' => true,
                'div' => false,
            )
        );

        return $button;
    }

    /**
     * Creates a field with autocomplete. The "real" field is hidden and receives the value part of the selection.
     * The helper creates an extra field to support the autocomplete feature, showing the label part of the selection.
     *
     * Options:
     *
     * 'url' => a CakePHP url array to request the autocomplete data.
     *     search criteria arrives to the controller as $this->params['url']['term']
     *     the controller should return a JSON associative array with label and value keys
     *
     * @param string $field
     * @param string $options
     *
     * @return HTML
     */
    public function autocomplete($field, $options = array())
    {
        $options['type'] = 'autocomplete';

        return $this->input($field, $options);
    }
	
/**
 * Wrapper for FormHelper->input
 *
 * @param string $field
 * @param array  $options
 *
 * @return HTML
 */

	public function input($field, $options = array()) {
		// Normalize options
		if (!empty($options['options'])) {
			$options['type'] = 'select';
		}
		if (!empty($options['icon'])) {
			$options['prefix'] = '<i class="fi-'.$options['icon'].'"></i>';
		}
		$options = Set::merge($this->defaults, $options);

		// Prepare options for div
		if (is_string($options['div'])) {
			$options['div'] = array('class' => $options['div']);
		}
		$divAttr = $options['div'];


        // Clean FormHelper options
		$cleanOptions = $this->_cleanFormHelperOptions($options);

		// Generate DOM Id for the input to use in JS
		$inputSelector = $this->domIdForField($field);
		$divAttr['id'] = 'div'.$inputSelector;

		if (!empty($options['clearable'])) {
			$button = $this->Html->link(
                '',
                'javascript:void(0)',
                array(
                    'class' => 'mh-clearfield postfix button fi-x',
                    'escape' => false,
					'mh-target' => '#'.$inputSelector
			));
			$options['postfix'] = $button;
			$options['wrapPostfix'] = false;
		}


        // Show pop-up help

		if (!empty($options['help'])) {
			$divAttr['title'] = $options['help'];
			$divAttr['has-tip'] = true;
			$divAttr['data-tooltip'] = true;
			$divAttr['aria-haspopup'] = true;
			$divAttr['data-options'] = "disable_for_touch:true, show_on:large";
		}

		if (!empty($options['mh-show-on-empty'])) {
			$cleanOptions['class'] = 'mh-show-by-value';
		}

		// Generates the input, calling FormHelper, a wrapping method or another Helper method
		switch ($options['type']) {
			case 'select':
				$theInput = $this->Form->input($field, $cleanOptions);
				if (!empty($cleanOptions['multiple']) && $cleanOptions['multiple'] == 'checkbox') {
					$theInput = $this->Html->div('mh-multiple-checkbox', $theInput);
				}
				break;
			case 'date':
				$theInput = $this->_date($field, $cleanOptions);
				break;
			case 'time':
				$theInput = $this->_time($field, $cleanOptions);
				break;
			case 'autocomplete':
				$theInput = $this->_autocomplete($field, $cleanOptions);
				break;
			case 'password':
				$theInput = $this->Form->input($field, $cleanOptions);
				break;
			case 'checkbox':
				$theInput = $this->_checkbox($field, $cleanOptions);
				break;
			case 'uploader':
			case 'image':
			case 'images':
			case 'multimedia':
			case 'file':
			case 'enclosure':
				$cleanOptions = $this->_cleanUploadHelperOptions($options);
				$theInput = $this->Upload->{$options['type']}($field, $cleanOptions);
				break;
			case 'textarea':
				$theInput = $this->Form->textarea($field, $cleanOptions);
				break;
			case 'email':
				$theInput = $this->Form->text($field, $cleanOptions);
				break;
			case 'number':
				$theInput = $this->Form->text($field, $cleanOptions);
			break;
			default:
				$theInput = $this->Form->text($field, $cleanOptions);
				break;
		}
		// Prepare elements
		$theInput = $theInput . $this->Form->error($field, $options['error']);
		$theLabel = $this->prepareLabel($field, $options);
		$thePrefix = $this->preparePrefix($options);
		$thePostfix = $this->preparePostfix($options);

		// Options to style as corners (currently doesn´t work)
		if (!empty($options['corners'])) {
			$rowClass = 'row collapse '.(!empty($options['prefix']) ? 'prefix' : 'postfix').'-'.$options['corners'];
		} else {
			$rowClass = 'row collapse';
		}

		// AjaxLoading ?

		if (!empty($options['indicator'])) {
			if ($options['indicator'] !== true) {
				$busySelector = $options['indicator'];
			} else {
				$busySelector = $divAttr['id'].'-busy';
			}
			$theInput = $this->XHtml->ajaxLoading($busySelector) . $theInput;
		}

		// Builds the control
		if (!empty($options['div'])) {
			if ($options['labelPosition'] == 'inline') {
				$code = $this->buildInLine($theInput, $theLabel, $thePrefix, $thePostfix, $options);
				return $this->Html->div('small-12 columns', $code, $divAttr);
			}
			$code = $this->buildStandar($theInput, $theLabel, $thePrefix, $thePostfix, $options);
			return $this->Html->div($options['div']['class'], $code, $divAttr);

		}
		return $theInput;
	}

    /**
     * Prepare clean options for Form Helper calls
     *
     * @param array $options
     *
     * @return array
     */
    protected function _cleanFormHelperOptions($options = array())
    {
        // $options = array_intersect_key($options, $this->formHelperOptions);
        $options['div'] = $options['label'] = false;

        return $options;
    }

    /**
     * Builds a DOM ID for a given field
     *
     * @param string $field
     *
     * @return void
     */
    public function domIdForField($field)
    {
        $this->setEntity($field);
        $view = ClassRegistry::getObject('view');
        $parts = $view->entity();
        $selector = '';
        foreach ($parts as $part) {
            // ad-hoc solution for a problem with the field name when starts with _
            if (substr($part, 0, 1) == '_') {
                $selector .= '_'.Inflector::Classify($part);
            } else {
                $selector .= Inflector::Classify($part);
            }
        }

        return $selector;
    }

    protected function _date($field, $options = array())
    {
        if (!empty($options['multi'])) {
            $class = 'mh-multidate';
        } elseif (!empty($options['range'])) {
            $class = 'mh-date-range';
        } else {
            $class = 'mh-date';
        }

        $options['type'] = 'text';

        if (empty($options['class'])) {
            $options['class'] = $class;
        } else {
            $options['class'] .= ' '.$class;
        }

        if ($value = $this->Form->value($field)) {
            $options['value'] = date('d-m-Y', strtotime($value));
        }
        $options['mh-altfield'] = '#'.$this->domIdForField($field);

        return $this->Form->input($field.'-alt', $options).$this->Form->input($field, array('type' => 'hidden'));
    }

    public function _time($field, $options = array())
    {
        $format24 = true;
        $selected = null;
        $options['class'] = 'medium-6';
        $code = $this->Form->hour($field, $format24, $selected, $options);
        $code .= $this->Form->minute($field, $selected, $options);
        $code = $this->Html->div(null, $code);

        return $code;
    }

// Wrapper methods for specialized fields

    public function _autocomplete($field, $options = array())
    {
        $fieldComplete = $field.'-complete';
        $selector = $this->domIdForField($field);
        $selectorComplete = $this->domIdForField($fieldComplete);
        $fieldOptions = array(
            'mh-url' => Router::url($options['url']),
            'mh-target' => $selector,
            'class' => 'mh-autocomplete',
            'div' => false,
            'label' => false,
            'type' => 'text',
            'value' => !empty($options['valueLabel']) ? $options['valueLabel'] : '',
        );

        return $this->Form->input(
                $field,
                array(
                    'type' => 'hidden',
                    'label' => false,
                    'div' => false,
                    'value' => $this->Form->value($field),
                )
            ).$this->Form->input($fieldComplete, $fieldOptions);
    }

    protected function _checkbox($field, $options = array())
    {
        $options['div']['class'] = 'switch round';
        $theLabel = $this->Form->label($field, $options['label']);
        unset($options['label']);
        $theInput = $this->Form->checkbox($field, $options);
        $code = $this->Html->div($options['div']['class'], $theInput.$theLabel);

        return $code;
    }

    /**
     * Prepare clean options for Upload Helper calls
     *
     * @param array $options
     *
     * @return array
     */
    protected function _cleanUploadHelperOptions($options = array())
    {
        $options = array_intersect_key($options, $this->Upload->defaults);
        unset($options['label'], $options['before'], $options['after']);
        $options['bare'] = true;

        return $options;
    }

	private function prepareLabel($field, &$options)
	{
		if (empty($options['label'])) {
			return '';
		} elseif ($options['labelPosition'] == 'inline'){
			return $this->Form->label($field, $options['label'], array('class' => 'right inline'));
		}
		return $this->Form->label($field, $options['label']);
	}
	
	private function preparePrefix(&$options)
	{
		if (empty($options['prefix'])) {
			return '';
		}
		return $this->Html->tag('span', $options['prefix'], array('class' => 'prefix'));
	}

	private function preparePostfix(&$options)
	{
		if (empty($options['postfix'])) {
			return '';
		}
		if ($options['wrapPostfix']) {
			return $this->Html->tag('span', $options['postfix'], array('class' => 'postfix'));
		} else {
			return $options['postfix'];
		}
	}

	private function buildInline($input, $label, $prefix, $postfix, &$options)
	{
		$inputClass = 'small-'.$this->computeInputSize($options).' columns'. ($postfix ? '' : ' end');
		$code = $this->Html->div($inputClass, $input);
		if ($prefix) {
			$code = $this->Html->div('small-'.$options['prefixSize'].' columns', $prefix) .$code;
		}
		if ($postfix) {
			$code = $code . $this->Html->div('small-'.$options['postfixSize'].' columns end', $postfix);
		}
		$code = $this->Html->div('row collapse', $code);
		if ($label) {
			$code = $this->Html->div('small-'.$options['labelSize'].' columns', $label) . $code;
		}
		return $this->Html->div('row', $code);
    }

    private function computeInputSize(&$options)
    {
        $extra = ($options['prefix'] ? $options['prefixSize'] : 0) + ($options['postfix'] ? $options['postfixSize'] : 0) + ($options['labelPosition'] == 'inline' ? $options['labelSize'] : 0);

        if (($options['inputSize'] + $extra) > 12) {
            return (12 - $extra);
        }

        return $options['inputSize'];
    }
	
	private function buildStandar($input, $label, $prefix, $postfix, &$options)
	{
		$inputClass = 'small-'.$this->computeInputSize($options).' columns'. ($postfix ? '' : ' end');
		$code = $this->Html->div($inputClass, $input);
		if ($prefix) {
			$code = $this->Html->div('small-'.$options['prefixSize'].' columns', $prefix) .$code;
		}
		if ($postfix) {
			$code = $code . $this->Html->div('small-'.$options['postfixSize'].' columns end', $postfix);
		}
		$code = $this->Html->div('row collapse', $code);
		if ($label) {
			$code = $this->Html->tag('label', $label. $code);
		}
		return $code;
	}

/**
 * Simple text input field
 *
 * @param string $field
 * @param string $options
 *
 * @return string
 */
	public function text($field, $options = array()) {
		$options['type'] = 'text';
		return $this->input($field, $options);
	}

	public function password($field, $options = array()) {
		$options['type'] = 'password';
		$options['icon'] = 'key';

		return $this->input($field, $options);
	}

	public function number($field, $options = array()) {
		$options['type'] = 'number';
		if (!empty($options['class'])) {
			$options['class'] .= ' ';
		}
		$options['class'] = 'text-right';
		return $this->input($field, $options);
	}
	
/**
 * Date field with datepicker
 *
 * @param string $field
 * @param string $options
 *
 * @return string
 */

	public function date($field, $options = array()) {
		$options['type'] = 'date';
		$options['icon'] = 'calendar';
		return $this->input($field, $options);
	}
	
/**
 * Different upload fields
 *
 * @param string $field
 * @param string $options
 *
 * @return string
 */
	public function upload($field, $options = array()) {
		$options['type'] = 'uploader';
		return $this->input($field, $options);
	}

	public function image($field, $options = array()) {
		$options['type'] = 'image';
		return $this->input($field, $options);
	}
	
	public function images($field, $options = array()) {
		$options['type'] = 'images';
		return $this->input($field, $options);
	}

	public function file($field, $options = array()) {
		$options['type'] = 'file';
		return $this->input($field, $options);
	}

	public function files($field, $options = array()) {
		$options['type'] = 'file';
		return $this->input($field, $options);
	}

	public function multimedia($field, $options = array()) {
		$options['type'] = 'multimedia';
		return $this->input($field, $options);
	}
	
	public function enclosure($field, $options = array()) {
		$options['type'] = 'enclosure';
		return $this->input($field, $options);
	}

	public function checkbox($field, $options = array()) {
		$options['type'] = 'checkbox';
		return $this->input($field, $options);
	}

/**
 * A select field
 *
 * options
 * empty
 * multiple
 *
 * @param string $field
 * @param string $options
 *
 * @return string
 */
	public function select($field, $options = array()) {
		if (isset($options['readonly'])) {
			$value = $this->Form->value($field);
			$code = $this->pseudo($value, $options);
			$code .= $this->hidden($field);
			return $code;
		}
		$options['type'] = 'select';
		return $this->input($field, $options);
    }

    public function pseudo($value, $options = array())
    {
        if (isset($options['options'])) {
            $options['value'] = $options['options'][$value];
            unset($options['options']);
        } else {
            $options['value'] = $value;
        }
        $options['type'] = 'text';
        $options['readonly'] = true;

        return $this->input('afield', $options);
    }

    /**
     * Creates hidden fields
     *
     * @param array $fields array of fields
     *
     * @return HTML
     */
    public function hidden($fields)
    {
        if (is_string($fields)) {
            $fields = array($fields);
        }
        foreach ($fields as $field) {
            $code[] = $this->Form->input($field, array('type' => 'hidden'));
        }

        return implode(chr(10), $code);
    }
	
/**
 * Textarea input field
 *
 * rows (5)
 *
 * @param string $field
 * @param string $options
 *
 * @return string
 */

	public function textarea($field, $options = array()) {
		$options['type'] = 'textarea';
		if (empty($options['rows'])) {
			$options['rows'] = 5;
		}
		return $this->input($field, $options);
	}

	public function translate($field, $options = array()) {
		list($model, $fieldName, $tl) = explode('.', $field);
		$buttonOptionsKeys = array(
			'sl' => true
		);
		$buttonOptions = array(
			'type' => 'button',
			'class' => 'mh-translate postfix button fi-arrow-left',
			'sl' => null,
			'tl' => $tl
		);
		$buttonOptions = array_merge($buttonOptions, array_intersect_key($options, $buttonOptionsKeys));
		$buttonOptions['sfield'] = Inflector::Classify($model).Inflector::Classify($fieldName).Inflector::Classify($buttonOptions['sl']);
		$buttonOptions['tfield'] = Inflector::Classify($model).Inflector::Classify($fieldName).Inflector::Classify($buttonOptions['tl']);

		$buttonLabel = sprintf(__d('circulars', '%s', true), __d('circulars', $buttonOptions['sl'], true));
		$button = $this->Html->link(
            $buttonLabel,
            'javascript:void(0)',
			$buttonOptions
		);
		$options['postfix'] = $button;
		$options['wrapPostfix'] = false;

		$options['ajaxLoading'] = true;

		$type = 'text';
		if (!empty($options['rows'])) {
			$type = 'textarea';
		}
		$options['type'] = $type;
		return $this->input($field, $options);
    }

    public function days($field, $options = array())
    {
        if (is_string($options)) {
            $options['format'] = $options;
        }
        $types = array(
            'labor' => array(
                1 => __('monday', true),
                2 => __('tuesday', true),
                4 => __('wednesday', true),
                8 => __('thursday', true),
                16 => __('friday', true),
            ),
            'week' => array(
                1 => __('monday', true),
                2 => __('tuesday', true),
                4 => __('wednesday', true),
                8 => __('thursday', true),
                16 => __('friday', true),
                32 => __('saturday', true),
                64 => __('sunday', true),
            ),
        );

        if (!isset($options['format']) || !in_array($options['format'], array_keys($types))) {
            $options['format'] = 'week';
        }

        $options['options'] = $types[$options['format']];
        if (!isset($options['checkall'])) {
            $options['checkall'] = true;
        }
        $options['multiple'] = 'checkbox';
        $options['type'] = 'select';

        return $this->binary($field, $options);
    }

/**
 * Builds a form field to input binary packaged values
 *
 * @param string $field The field
 * @param array $options Options
 *		'bits' => length of the binary number
 *		'sort' => asc/desc order of bits
 *		'options' => array of options/labels - numeric binary packed key => label
 *
 * @return void
 */
	public function binary($field, $options = array()) {
		// if (isset($options['multiple'])) {
		// 	unset($options['multiple']);
		// }

		$fakeOptions = false; // Flag to build the options list
		if (!isset($options['options'])) {
			$fakeOptions = true;
		} else {
			$options['bits'] = count($options['options']);
		}
		$options = Set::merge($this->defaults, $options);
		$value = $this->Form->value($field);
		$aValue = array();
        for ($i = 0; $i < $options['bits']; $i++) {
			$v = pow(2, $i);
			if ($fakeOptions) {
				$options['options'][$v] = "2^$i";
			}
			if ($v & $value) {
				$aValue[] = $v;
			}
		}
		$options['value'] = $aValue;
		return $this->checkboxes($field, $options);
    }

    /**
     * Creates a checkboxes select field with an associated button to check/uncheck all
     *
     * @param string $field
     * @param string $options
     *
     * @return void
     * @author Fran Iglesias
     */
    public function checkboxes($field, $options) {
		$options['type'] = 'select';
        $options['multiple'] = 'checkbox';
        $selector = $this->domIdForField($field);
        if (!empty($options['checkall'])) {
            $all = __('Check All', true);
            $uncheckAll = __('Uncheck All', true);
            $button = $this->Form->submit(
                $all,
                array(
                    'id' => $selector.'-all',
                    'type' => 'button',
                    'class' => 'mh-check-all',
                    'mh-target' => $selector,
                    'mh-message-check' => $all,
                    'mh-message-uncheck' => $uncheckAll,
                    'value' => $all,
                    'div' => false,
                )
            );
            $options['after'] = $button;
        }

        return $this->input($field, $options);
	}
	
	public function time($field, $options = array())
	{
		$options['type'] = 'time';
		return $this->input($field, $options);
	}
	
/**
 * Simple email html5 input field
 *
 * @param string $field
 * @param array  $options
 *
 * @return string
 */
	public function email($field, $options = array()) {
		$options['type'] = 'email';
		$options['icon'] = 'mail';
		return $this->input($field, $options);
	}

	public function icons($field, $options = array())
	{
		$options['type'] = 'select';
		$options['options'] = array(
		'General Icons' => array(
			'heart' => 'Heart',
			'star' => 'Star',
			'plus' => 'Plus',
			'minus' => 'Minus',
			'x' => 'X',
			'check' => 'Check',
			'upload' => 'Upload',
			'download' => 'Download',
			'widget' => 'Widget',
			'marker' => 'Marker',
			'refresh' => 'Refresh',
			'home' => 'Home',
			'trash' => 'Trash',
			'paperclip' => 'Paperclip',
			'lock' => 'Lock',
			'unlock' => 'Unlock',
			'calendar' => 'Calendar',
			'cloud' => 'Cloud',
			'magnifying-glass' => 'Magnifying-glass',
			'zoom-out' => 'Zoom-out',
			'zoom-in' => 'Zoom-in',
			'wrench' => 'Wrench',
			'rss' => 'Rss',
			'share' => 'Share',
			'flag' => 'Flag',
			'list-thumbnails' => 'List-thumbnails',
			'list' => 'List',
			'thumbnails' => 'Thumbnails',
			'annotate' => 'Annotate',
			'folder' => 'Folder',
			'folder-lock' => 'Folder-lock',
			'folder-add' => 'Folder-add',
			'clock' => 'Clock',
			'play-video' => 'Play-video',
			'crop' => 'Crop',
			'archive' => 'Archive',
			'pencil' => 'Pencil',
			'graph-trend' => 'Graph-trend',
			'graph-bar' => 'Graph-bar',
			'graph-horizontal' => 'Graph-horizontal',
			'graph-pie' => 'Graph-pie',
			'checkbox' => 'Checkbox',
			'minus-circle' => 'Minus-circle',
			'x-circle' => 'X-circle',
			'eye' => 'Eye',
			'database' => 'Database',
			'results' => 'Results',
			'results-demographics' => 'Results-demographics',
			'like' => 'Like',
			'dislike' => 'Dislike',
			'upload-cloud' => 'Upload-cloud',
			'camera' => 'Camera',
			'alert' => 'Alert',
			'bookmark' => 'Bookmark',
			'contrast' => 'Contrast',
			'mail' => 'Mail',
			'video' => 'Video',
			'telephone' => 'Telephone',
			'comment' => 'Comment',
			'comment-video' => 'Comment-video',
			'comment-quotes' => 'Comment-quotes',
			'comment-minus' => 'Comment-minus',
			'comments' => 'Comments',
			'microphone' => 'Microphone',
			'megaphone' => 'Megaphone',
			'sound' => 'Sound',
			'address-book' => 'Address-book',
			'bluetooth' => 'Bluetooth',
			'html5' => 'Html5',
			'css3' => 'Css3',
			'layout' => 'Layout',
			'web' => 'Web',
			'foundation' => 'Foundation',
		),
		'Page Icons' => array(
			'page' => 'Page',
			'page-csv' => 'Page-csv',
			'page-doc' => 'Page-doc',
			'page-pdf' => 'Page-pdf',
			'page-export' => 'Page-export',
			'page-export-csv' => 'Page-export-csv',
			'page-export-doc' => 'Page-export-doc',
			'page-export-pdf' => 'Page-export-pdf',
			'page-add' => 'Page-add',
			'page-remove' => 'Page-remove',
			'page-delete' => 'Page-delete',
			'page-edit' => 'Page-edit',
			'page-search' => 'Page-search',
			'page-copy' => 'Page-copy',
			'page-filled' => 'Page-filled',
			'page-multiple' => 'Page-multiple',
		),
		'Arrow Icons' => array(
			'arrow-up' => 'Arrow-up',
			'arrow-right' => 'Arrow-right',
			'arrow-down' => 'Arrow-down',
			'arrow-left' => 'Arrow-left',
			'arrows-out' => 'Arrows-out',
			'arrows-in' => 'Arrows-in',
			'arrows-expand' => 'Arrows-expand',
			'arrows-compress' => 'Arrows-compress',
		),
		'People Icons' => array(
			'torso' => 'Torso',
			'torso-female' => 'Torso-female',
			'torsos' => 'Torsos',
			'torsos-female-male' => 'Torsos-female-male',
			'torsos-male-female' => 'Torsos-male-female',
			'torsos-all' => 'Torsos-all',
			'torsos-all-female' => 'Torsos-all-female',
			'torso-business' => 'Torso-business',
		),
		'Device Icons' => array(
			'monitor' => 'Monitor',
			'laptop' => 'Laptop',
			'tablet-portrait' => 'Tablet-portrait',
			'tablet-landscape' => 'Tablet-landscape',
			'mobile' => 'Mobile',
			'mobile-signal' => 'Mobile-signal',
			'usb' => 'Usb',
		),
		'Text Editor Icons' => array(
			'bold' => 'Bold',
			'italic' => 'Italic',
			'underline' => 'Underline',
			'strike' => 'Strike',
			'text-color' => 'Text-color',
			'background-color' => 'Background-color',
			'superscript' => 'Superscript',
			'subscript' => 'Subscript',
			'align-left' => 'Align-left',
			'align-center' => 'Align-center',
			'align-right' => 'Align-right',
			'align-justify' => 'Align-justify',
			'list-numbered' => 'List-numbered',
			'list-bullet' => 'List-bullet',
			'indent-more' => 'Indent-more',
			'indent-less' => 'Indent-less',
			'print' => 'Print',
			'save' => 'Save',
			'photo' => 'Photo',
			'filter' => 'Filter',
			'paint-bucket' => 'Paint-bucket',
			'link' => 'Link',
			'unlink' => 'Unlink',
			'quote' => 'Quote',
		),
		'Media Control Icons' => array(
			'play' => 'Play',
			'stop' => 'Stop',
			'pause' => 'Pause',
			'previous' => 'Previous',
			'rewind' => 'Rewind',
			'fast-forward' => 'Fast-forward',
			'next' => 'Next',
			'record' => 'Record',
			'play-circle' => 'Play-circle',
			'volume-none' => 'Volume-none',
			'volume' => 'Volume',
			'volume-strike' => 'Volume-strike',
			'loop' => 'Loop',
			'shuffle' => 'Shuffle',
			'eject' => 'Eject',
			'rewind-ten' => 'Rewind-ten',
		),
		'Ecommerce Icons' => array(
			'dollar' => 'Dollar',
			'euro' => 'Euro',
			'pound' => 'Pound',
			'yen' => 'Yen',
			'bitcoin' => 'Bitcoin',
			'bitcoin-circle' => 'Bitcoin-circle',
			'credit-card' => 'Credit-card',
			'shopping-cart' => 'Shopping-cart',
			'burst' => 'Burst',
			'burst-new' => 'Burst-new',
			'burst-sale' => 'Burst-sale',
			'paypal' => 'Paypal',
			'price-tag' => 'Price-tag',
			'pricetag-multiple' => 'Pricetag-multiple',
			'shopping-bag' => 'Shopping-bag',
			'dollar-bill' => 'Dollar-bill',
		),
		'Accessibility Icons' => array(
			'wheelchair' => 'Wheelchair',
			'braille' => 'Braille',
			'closed-caption' => 'Closed-caption',
			'blind' => 'Blind',
			'asl' => 'Asl',
			'hearing-aid' => 'Hearing-aid',
			'guide-dog' => 'Guide-dog',
			'universal-access' => 'Universal-access',
			'telephone-accessible' => 'Telephone-accessible',
			'elevator' => 'Elevator',
			'male' => 'Male',
			'female' => 'Female',
			'male-female' => 'Male-female',
			'male-symbol' => 'Male-symbol',
			'female-symbol' => 'Female-symbol',
		),
		'Social & Brand Icons' => array(
			'social-500px' => 'Social-500px',
			'social-adobe' => 'Social-adobe',
			'social-amazon' => 'Social-amazon',
			'social-android' => 'Social-android',
			'social-apple' => 'Social-apple',
			'social-behance' => 'Social-behance',
			'social-bing' => 'Social-bing',
			'social-blogger' => 'Social-blogger',
			'social-delicious' => 'Social-delicious',
			'social-designer-news' => 'Social-designer-news',
			'social-deviant-art' => 'Social-deviant-art',
			'social-digg' => 'Social-digg',
			'social-dribbble' => 'Social-dribbble',
			'social-drive' => 'Social-drive',
			'social-dropbox' => 'Social-dropbox',
			'social-evernote' => 'Social-evernote',
			'social-facebook' => 'Social-facebook',
			'social-flickr' => 'Social-flickr',
			'social-forrst' => 'Social-forrst',
			'social-foursquare' => 'Social-foursquare',
			'social-game-center' => 'Social-game-center',
			'social-github' => 'Social-github',
			'social-google-plus' => 'Social-google-plus',
			'social-hacker-news' => 'Social-hacker-news',
			'social-hi5' => 'Social-hi5',
			'social-instagram' => 'Social-instagram',
			'social-joomla' => 'Social-joomla',
			'social-lastfm' => 'Social-lastfm',
			'social-linkedin' => 'Social-linkedin',
			'social-medium' => 'Social-medium',
			'social-myspace' => 'Social-myspace',
			'social-orkut' => 'Social-orkut',
			'social-path' => 'Social-path',
			'social-picasa' => 'Social-picasa',
			'social-pinterest' => 'Social-pinterest',
			'social-rdio' => 'Social-rdio',
			'social-reddit' => 'Social-reddit',
			'social-skype' => 'Social-skype',
			'social-skillshare' => 'Social-skillshare',
			'social-smashing-mag' => 'Social-smashing-mag',
			'social-snapchat' => 'Social-snapchat',
			'social-spotify' => 'Social-spotify',
			'social-squidoo' => 'Social-squidoo',
			'social-stack-overflow' => 'Social-stack-overflow',
			'social-steam' => 'Social-steam',
			'social-stumbleupon' => 'Social-stumbleupon',
			'social-treehouse' => 'Social-treehouse',
			'social-tumblr' => 'Social-tumblr',
			'social-twitter' => 'Social-twitter',
			'social-vimeo' => 'Social-vimeo',
			'social-windows' => 'Social-windows',
			'social-xbox' => 'Social-xbox',
			'social-yahoo' => 'Social-yahoo',
			'social-yelp' => 'Social-yelp',
			'social-youtube' => 'Social-youtube',
			'social-zerply' => 'Social-zerply',
			'social-zurb' => 'Social-zurb',
		),
		'Miscellaneous Icons' => array(
			'compass' => 'Compass',
			'music' => 'Music',
			'lightbulb' => 'Lightbulb',
			'battery-full' => 'Battery-full',
			'battery-half' => 'Battery-half',
			'battery-empty' => 'Battery-empty',
			'projection-screen' => 'Projection-screen',
			'info' => 'Info',
			'power' => 'Power',
			'asterisk' => 'Asterisk',
			'at-sign' => 'At-sign',
			'key' => 'Key',
			'ticket' => 'Ticket',
			'book' => 'Book',
			'book-bookmark' => 'Book-bookmark',
			'anchor' => 'Anchor',
			'puzzle' => 'Puzzle',
			'foot' => 'Foot',
			'paw' => 'Paw',
			'mountains' => 'Mountains',
			'trees' => 'Trees',
			'sheriff-badge' => 'Sheriff-badge',
			'first-aid' => 'First-aid',
			'trophy' => 'Trophy',
			'prohibited' => 'Prohibited',
			'no-dogs' => 'No-dogs',
			'no-smoking' => 'No-smoking',
			'safety-cone' => 'Safety-cone',
			'shield' => 'Shield',
			'crown' => 'Crown',
			'target' => 'Target',
			'target-two' => 'Target-two',
			'die-one' => 'Die-one',
			'die-two' => 'Die-two',
			'die-three' => 'Die-three',
			'die-four' => 'Die-four',
			'die-five' => 'Die-five',
			'die-six' => 'Die-six',
			'skull' => 'Skull',
			'map' => 'Map',
			'clipboard' => 'Clipboard',
			'clipboard-pencil' => 'Clipboard-pencil',
			'clipboard-notes' => 'Clipboard-notes',
			)
		);
		$options['empty'] = __d('ui', '-- Select an icon --', true);
		return $this->input($field, $options);
    }

// Utility methods

/**
 * Puts texts into the form
 *
 * @param strings
 *
 * @return string
 */

	public function help($options = 'small-12 columns', $texts) {
		$texts = func_get_args();
		$options = array_shift($texts);
		if (empty($options)) {
			$options = 'small-12 columns';
		}
		$code = array();
		foreach ($texts as $text) {
			$code[] = $this->Html->tag('p', $text, array('class' => ''));
        }

        return $this->Html->div($options, implode(chr(10), $code));
	}

	public function division($text, $options = array())
	{
		$options = Set::merge($this->defaults, $options);
		if ($options['labelPosition'] == 'standar') {
			return $this->Html->tag('p', $text);
		}
		return $this->Html->div('small-12 columns', $this->Html->tag('h4', $text, array('class' => 'division')));
    }

    /**
     * Uses $this->rotate to create the two needed buttons with common options
     *
     * @param string $options
     *
     * @return void
     * @author Fran Iglesias
     */
    public function rotateCombo($options)
    {
        $options['type'] = 'ccw';
        $html = $this->Html->tag('li', $this->rotate($options));
        $options['type'] = 'cw';
        $html .= $this->Html->tag('li', $this->rotate($options));
        $options['type'] = 'full';
        $html .= $this->Html->tag('li', $this->rotate($options));
        $html = $this->Html->tag('ul', $html, array('class' => 'mh-rotate-combo round'));

        return $html;
	}

/**
 * Creates a button to rotate an image
 *
 * @param array $options
 *	'size' => a size preset from theme_setup
 *	'file' => the path to the image
 *	'type' => cw/ccw
 *	'update' => the html element to update with the rotated image
 *
 * @return void
 * @author Fran Iglesias
 */
	public function rotate($options) {
		$defaults = array(
			'type' => 'cw',
			'size' => 'uploadPreviewImage',
			'update' => '#upload-image-preview'
		);
		$options = array_merge($defaults, $options);
		$buttonOptions = array(
			'class' => 'mh-btn-rotate',
			'type'  => 'button',
			'id' => 'RotateImageCCW'
		);
		$requestOptions = array(
			'update' => $options['update'],
			'beforeSend' => "$('#combo-busy-indicator').show(100);",
			'complete' => "$('#combo-busy-indicator').hide(100);",
			'data' => array(
				'file' => $options['file'],
				'angle' => $options['type'] == 'cw' ? 270 : ($options['type'] == 'ccw' ? 90 : 180),
				'size' => $options['size']
			),
			'type' => 'html',
			'async' => true
		);
		$label = __d('uploads', '⟲', true);
		if ($options['type'] == 'cw') {
			$buttonOptions['id'] = 'RotateImageCW';
			$label = __d('uploads', '⟳', true);
		} elseif ($options['type'] != 'ccw') {
			$buttonOptions['id'] = 'RotateImageFull';
			$label = __d('uploads', '⥀', true);
		}

		$buttonOptions = array(
			'class' => 'mh-btn-rotate mh-image-rotate',
			'mh-update' => $options['update'],
			'mh-indicator' => '#combo-busy-indicator',
			'mh-file' => $options['file'],
			'mh-angle' => $options['type'] == 'cw' ? 270 : ($options['type'] == 'ccw' ? 90 : 180),
			'mh-size' => $options['size'],
        );

        // $html = $this->Form->button($label, $buttonOptions);
		// $code = $this->Js->request('/uploads/uploads/rotate',$requestOptions);
		// $this->Js->get('#'.$buttonOptions['id']);
		// $this->Js->event('click', $code);

		$html = $this->Html->link(
			$label,
			array('plugin' => 'uploads', 'controller' => 'uploads', 'action' => 'rotate'),
			$buttonOptions
		);
		return $html;
	}

	
}
