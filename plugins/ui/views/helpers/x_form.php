<?php

/**
* XForm
*/
class XFormHelper extends AppHelper
{
	var $helpers = array('Html', 'Form', 'Js');
	var $defaults = array(
		'bits' => 5,
		'sort' => 'asc',
		'multiple' => 'checkbox'
		);
		
	public function beforeRender()
	{
		parent::beforeRender();
		$this->Html->script('/ui/js/jquery-ui', array('inline' => false));
		$this->Html->script('/ui/js/jquery.ui.datepicker-es', array('inline' => false));
		$this->Html->script('/ui/js/jquery-ui.multidatespicker', array('inline' => false));
		$this->Html->script('/ui/js/mh.xform.refresh', array('inline' => false));
		$this->Html->script('/ui/js/mh.xform', array('inline' => false));
		$this->Html->css('/ui/css/jquery-ui', null, array('inline' => false));
	}

/**
 * Builds a form field to input binary packaged values
 *
 * @param string $field The field
 * @param array $options Options
 *		'bits' => length of the binary number
 *		'sort' => asc/desc order of bits
 *		'options' => array of options/labels - numeric binary packed key => label
 * @return void
 */	
	public function binary($field, $options = array())
	{
		if (isset($options['multiple'])) {
			unset($options['multiple']);
		}
		
		$fakeOptions = false; // Flag to build the options list
		if (!isset($options['options'])) {
			$fakeOptions = true;
		} else {
			$options['bits'] = count($options['options']);
		}
		$options = Set::merge($this->defaults, $options);
		$value = $this->Form->value($field);
		$aValue = array();
		for ($i=0; $i < $options['bits']; $i++) { 
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
 * Builds a day selector field that is binary packaged
 *
 * @param string $field The field
 * @param array $options  or string to set a format.
 *		'format' => 'week', 'labor'. Defaults to week
 * @return void
 */	
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
				64 => __('sunday', true)
				)
			);
			
		if (!isset($options['format']) || !in_array($options['format'], array_keys($types))) {
			$options['format'] = 'week';
		}
		
		$options['options'] = $types[$options['format']];
		if (!isset($options['checkall'])) {
			$options['checkall'] = true;
		}

		return $this->binary($field, $options);
	}


/**
 * Creates a checkboxes select field with an associated button to check/uncheck all
 *
 * @param string $field 
 * @param string $options 
 * @return void
 * @author Fran Iglesias
 */
	public function checkboxes($field, $options)
	{
		$this->Html->script('/ui/js/mh.xform.checkboxes', array('inline' => false));
		
		$options['type'] = 'select';
		$options['multiple'] = 'checkbox';
		$selector = $this->domIdForField($field);
		if (!empty($options['checkall'])) {
			$all = __('Check All', true);
			$uncheckAll = __('Uncheck All', true);
			$button = $this->Form->submit($all, array(
				'id' => $selector.'-all', 
				'type' => 'button', 
				'class' => 'mh-check-all', 
				'mh-target' => $selector, 
				'mh-message-check' => $all,
				'mh-message-uncheck' => $uncheckAll,
				'value' => $all
			));
			$options['after'] = $button;
		}
		return $this->Form->input($field, $options);
	}

/**
 * Created a date field with js ui datepicker and a clear button
 *
 * @param string $field 
 * @param string $options 
 * @return void
 */

	public function date($field, $options = array())
	{
		if (!empty($options['multi'])) {
			$class = 'a-multidate';
		} elseif (!empty($options['range'])) {
			$class = 'a-date-range';
		} else {
			$class = 'a-date';
		}
		$selector = $this->domIdForField($field);
		$options['type'] = 'text';
		if (!empty($options['class'])) {$options['class'] .= ' ';} else {$options['class'] = '';}
		$options['class'] .= $class.' input-medium mh-clearable';
		$options['altfield'] = $options['mh-altfield'] = '#'.$selector;
		if ($value = $this->Form->value($field)) {
			$options['value'] = date('d-m-Y', strtotime($value));
		}
		$options['div']['class'] = 'small-8 columns';
		$options['label'] = false;
		$code = $this->Form->input($field.'-alt', $options);
		$code = $this->Html->div('row collapse postfix-radius', $code);
		$code .= $this->Form->input($field, array('type' => 'hidden'));
		return $code;
	}

	
/**
 * Creates a field with autocomplete. The "real" field is hidden and receives the value part of the selection.
 * The helper creates an extra field to support the autocomplete feature, showing the label part of the selection.
 *
 * Options:
 *
 * 'url' => a CakePHP url array to request the autocomplete data. 
 *     search criteria arrives to the controller as $this->params['url']['term']
 * 'labelPath' => the path to get the label in the response data (example Student.id)
 * 'valuePath' => the path to get the value in the response data (example Teacher.name)
 *
 * @param string $field 
 * @param string $options 
 * @return void
 */	
	public function autocomplete($field, $options = array())
	{
		$fieldComplete = $field.'-complete';
		
		$selector = $this->domIdForField($field);
		$selectorComplete = $this->domIdForField($fieldComplete);
		
		$fieldOptions = array_merge($options, array('type' => 'text'));
		
		$ret = $this->Form->input($field, array('type' => 'hidden'));
		$ret .= $this->Form->input($fieldComplete, $fieldOptions);

		$url = Router::url($options['url']);
		
		$labelPath = $options['labelPath'];
		$valuePath = $options['valuePath'];
		$ret .= $this->Html->script('/ui/js/jquery-ui', array('inline' => false));
		$ret .= $this->Html->css('/ui/css/jquery-ui', null, array('inline' => false));
$code = <<<JS
$(function() {
	$("#{$selectorComplete}").autocomplete({
		minLength: 3,
		source: function(request, response) {
			$.getJSON("{$url}", {
				term: request.term
			}, 	function(data) {
					response($.map(data, function(item) {
						return {
							label: item.{$labelPath}, value: item.{$valuePath}
						}
					}));
				});
		},
		focus: function (event, ui) {
			$( "#{$selectorComplete}" ).val( ui.item.label );
			return false
		},
		select: function  (event, ui) {
			$( "#{$selector}" ).val( ui.item.value );
			$( "#{$selectorComplete}" ).val( ui.item.label );
			return false;
		},
	});
});
JS;
		$ret .= $this->Html->scriptBlock($code, array('inline' => false));
		return $ret;
	}

/**
 * Puts a help text in a form. Any number or string as arguments. Will become paragraphs.
 *
 * @return void
 */	
	public function help()
	{
		$texts = func_get_args();
		$code = array();
		foreach ($texts as $text) {
			$code[] = $this->Html->tag('p', $text, array('class' => 'mh-message mh-info'));
		}
		return $this->Html->div('input help help-block', implode(chr(10), $code));
	}


/**
 * Build an ajax powered add button for edit views with children records
 *
 * @param string $url 
 * @param string $options 
 * @return void
 */
	public function ajaxAdd($url, $options = array())
	{
		if (empty($options['parentModel'])) {
			$options['parentModel'] = $this->model();
		}
		
		if (empty($options['class'])) {
			$options['class'] = 'mh-button mh-button-ok mh-button-add';
		}
		

		$childModel = str_replace('_', '-', Inflector::underscore($options['childModel']));
		$buttonId = 'add-'.$childModel;

		if (empty($options['update'])) {
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
		
		$this->Js->get('#'.$buttonId);
		$complete = '$("'.$options['update'].'").dialog({autoOpen: true, modal: true,width: 800,height: 600});';
		$this->Js->event('click', $this->Js->request($url, array(
					'complete' => $complete.' $("#'.$options['focus'].'").scrollToMe();',
					'update' => $options['update'],
					'async' => true,
					'evalScripts' => true
					)
				)
			);

		$code = $this->Form->button(
			$options['label'],
			array(
				'type' => 'button',
				'name' => 'add',
				'id' => $buttonId,
				'class' => $options['class']
			)
		);
		$code = $this->Html->div('submit', $code, array('id' => 'ajax-buttons'));
		return $code;
	}

/**
 * Build an Ajax powered Send button for edit views of children records
 *
 * @param string $url 
 * @param string $options 
 * @return void
 */	
	public function ajaxSend($url, $options = array())
	{
		if (empty($options['model'])) {
			$options['model'] = $this->model();
		}
		
		if (empty($options['label'])) {
			$options['label'] = sprintf(__('Submit %s', true), $options['model']);
		}
		
		if (empty($options['class'])) {
			$options['class'] = 'mh-button mh-button-ok';
		}
		
		$modelId = str_replace('_', '-', Inflector::underscore($options['model']));
		
		if (empty($options['update'])) {
			$options['update'] = '#'.$modelId.'-form';
		}
		
		if (empty($options['focus'])) {
			$options['focus'] = '#'.str_replace('_', '-', Inflector::underscore(Inflector::pluralize($options['model']))).'-list';
		}
		
		$url = $this->mergePagination($url);
		$url = Router::url($url, true);
		$complete = '$("'.$options['update'].'").dialog("close");';
		
		$code = $this->Js->submit($options['label'], array(
			'update' => $options['update'],
			'success' => $this->Js->request($url, array(
				'beforeSend' => $complete.'$("#busy-indicator").fadeIn()',
				'complete' => '$("#busy-indicator").fadeOut(); $("'.$options['focus'].'").scrollToMe(); ',
				'update' => $options['focus']
				)),
			'buffer' => false, 
			'evalScritps' => true,
			'class' => $options['class']
			)
		);
		return $code;
	}


/**
 * Get pagination parameters from current URL and merges into a $url for an Ajax Request
 *
 * @param string $url The URL for the Ajax request
 * @return array URL with the pagination parameters merged
 */	
	public function mergePagination($url)
	{
		$extract = array('page' => true, 'sort' => true, 'direction' => true);
		$pagination = array_intersect_key($this->params['named'], $extract);
		$url = array_merge($url, $pagination);
		return $url;
	}

/**
 * Builds a DOM ID for a given field
 *
 * @param string $field 
 * @return void
 */
	public function domIdForField($field)
	{
		$this->setEntity($field);
		$view =& ClassRegistry::getObject('view');
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

/**
 * Creates a button to rotate an image
 *
 * @param array $options 
 *	'size' => a size preset from theme_setup
 *	'file' => the path to the image
 *	'type' => cw/ccw
 *	'update' => the html element to update with the rotated image
 * @return void
 * @author Fran Iglesias
 */
	public function rotate($options)
	{
		$defaults = array(
			'type' => 'cw',
			'size' => 'uploadPreviewImage',
			'update' => '#upload-image-preview'
		);
		$options = array_merge($defaults, $options);
		$buttonOptions = array(
			'class' => 'mh-webkit-reset mh-button mh-button-rotate',
			'type'  => 'button',
			'id' => 'RotateImageCCW'
		);
		$requestOptions = array(
			'update' => $options['update'],
			'data' => array(
				'file' => $options['file'],
				'angle' => $options['type'] == 'cw' ? 270 : ($options['type'] == 'ccw' ? 90 : 180),
				'size' => $options['size']
			),
			'type' => 'html',
			'async' => true
		);
		$label = __d('uploads', '-90°', true);
		if ($options['type'] == 'cw') {
			$buttonOptions['id'] = 'RotateImageCW';
			$label = __d('uploads', '+90°', true);
		} elseif ($options['type'] != 'ccw') {
			$buttonOptions['id'] = 'RotateImageFull';
			$label = __d('uploads', '180°', true);
		}
		
		$html = $this->Form->button($label, $buttonOptions); 
		$code = $this->Js->request('/uploads/uploads/rotate',$requestOptions);
		$this->Js->get('#'.$buttonOptions['id']);
		$this->Js->event('click', $code);
		return $html;
	}

/**
 * Uses $this->rotate to create the two needed buttons with common options
 *
 * @param string $options 
 * @return void
 * @author Fran Iglesias
 */
	public function rotateCombo($options)
	{
		$options['type'] = 'ccw';
		$html = $this->rotate($options);
		$options['type'] = 'cw';
		$html .= $this->rotate($options);
		$options['type'] = 'full';
		$html .= $this->rotate($options);
		return $html;
	}
	
	public function xEnd($class = 'submit fixed-submit')
	{
		$code = array();
		$code[] = $this->Form->input('App.lastTab', array('type' => 'hidden'));
		$code[] = $this->Form->submit(__('Save and continue working', true), array(
				'name' => 'save_and_work',
				'class' => 'mh-button mh-button-ok mh-btn-ok right',
				'value' => true,
				'div' =>false
			));
		$code[] = $this->Form->submit(__('Save and Done', true), array(
				'name' => 'done',
				'value' => true,
				'class' => 'mh-button mh-button-ok mh-btn-ok left',
				'div' => false
			));
		$code = $this->Html->div($class, implode(chr(10), $code));
		$code .= chr(10). $this->Form->end();
		return $code;
	}
}


?>