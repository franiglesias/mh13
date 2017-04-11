<?php
/**
 * Table Helper
 * 
 * Builds tables for data arrays with sortable columns
 *
 * @package helpers.ui.milhojas
 * @version $Rev: 369 $
 * @license MIT License
 * 
 * $Id: table.php 369 2010-01-02 17:34:10Z franiglesias $
 * 
 * $HeadURL: http://franiglesias@subversion.assembla.com/svn/milhojas/trunk/views/helpers/table.php $
 * 
 **/
App::import('Core', 'Sanitize');
App::import('Lib', 'FiImage');


/**
 * Table Helper
 *
 * Basic Usage:
 *
 * echo $this->Table->render($data, $options);
 *
 * $data: an array with data, typically the result of a $Model->find('all');
 * $options: a keyed array. Main keys:
 *     'columns' => array of 'columns' => options: all columns you desire to show
 *     'actions' => array of 'actions' => options
 *     'table' => array of options for the table, see var $tableOptions for details
 *
 * @package default
 */

class TableHelper extends AppHelper
{
	var $helpers = array('Html', 'Form', 'Js', 'Paginator', 'Time', 'Number', 'Text', 'Ui.Media', 'Ui.FForm');
	
	
	var $data; // stores the normalized data array
	var $fields; // Stores definitions of columns for the table
	var $Columns; // Stores the columns
	var $altRow;
/**
 * Global table options, all are optional, so you really don't need to set them in many cases
 *
 * @var string
 */
	var $tableOptions = array(
		'id' => 'table',							// HTML id for the table element
		'class' => 'table',							// HTML class for the table element
		'attr' => array(),							// Other HTML attributes for the table element
		'model' => null,							// Default model for table
		'url' => array(),							// Url for the view where the table lives (special cases)
		'urlParams' => array(),						// Not implemented
		'ajax' => false,							// Make ajax table header buttons. Not implemented
		'break' => null, 							// A field to break table
		'selection' => false,						// Not implemented
		'formUrl' => array('action' => 'index'),	// Not implemented
		'totals' => false,							// array of Column => function
		'group' => false
		);
		
	var $columnActionsOptions = array(
		'icon' => 32,
		'format' => '%icon%'
		);
				
	var $defaultModel; // Default model for the table
	
	var $ajaxCallbacks = array(
		'success',
		'complete'
	);
	
/**
 * Renders a table for $data, using $options if provided
 *
 * @param string $data
 * @param string $options
 *
 * @return void
 */

	public function render($data, $options = array()) {
		if (!$data) {
			return $this->Html->tag('p', __('There is no data to show.', true), array('class' => 'mh-message mh-alert'));
		}
		
		if (empty($options['columns'])) {
			$options['columns'] = array();
		}

		// Set table Options
		if(!empty($options['table'])) {
			$this->tableOptions = array_merge($this->tableOptions, $options['table']);
			$this->tableOptions['attr']['class'] = $this->tableOptions['class'];
			$this->tableOptions['attr']['id'] = $this->tableOptions['id'];
			unset($options['table']);
		}
		// Get default model 
		$this->defaultModel = $this->params['models'][0];
		if (!empty($this->tableOptions['model'])) {
			$this->defaultModel = $this->tableOptions['model'];
		}
		
		if (!isset($this->Paginator->params['paging'])) {
			$this->Paginator->params['paging'] = array(
				$this->defaultModel => array(
					'defaults' => array(
						'page' => 1,
						'limit' => null
					),
					'options' => array(
						'page' => 1,
						'limit' => null
					)
				)
			);
		}
		
		
				
		$this->setFields($data);
		// Set and normalize data for table
		$this->normalize($data);
		if (isset($options['actions'])) {
			$options['columns']['actions']['actions'] = $options['actions'];
			$options['columns']['actions']['type'] = 'actions';
		}
		if (!empty($this->tableOptions['selection'])) {
			echo $this->Html->script('/ui/js/selection', array('inline' => false));
			$selectionColumn = array('selection' => array('type' => 'selection'));
			$options['columns'] = array_merge($selectionColumn, $options['columns']);
		}
		// Set and normalize visible columns
		$this->setColumns($options['columns']);
		$code = $this->headers();
		$code .= $this->body();
		$code = $this->Html->tag('table', $code, $this->tableOptions['attr']);
		
		if (!empty($this->tableOptions['selection'])) {
			$code = $this->_buildSelectionForm($code);
		}
		return $code;
	}

    /**
     * Extract and format the column names from the data array. Normalize column names
     * to Model.field, using the data available
     *
     * @param string $data
     *
     * @return void
     */
    function setFields(&$data)
    {
        if (empty($data)) {
            return false;
        }
        $row = $data[key($data)];
        $columns = array();
        $models = array_keys($row);
        foreach ($models as $model) {
            $fields = Set::extract($row, "/$model");
            // Fields provided without model, add default Model
            if (!is_array($fields[0])) {
                $columns[] = sprintf('%s.%s', $this->defaultModel, $model);
                continue;
            }
            $fields = array_keys($fields[0][$model]);
            foreach ($fields as $field) {
                $columns[] = sprintf('%s.%s', $model, $field);
            }
        }
        $this->fields = $columns;

        return true;
    }

    /**
     * Normalize the data array from [Model][field] to [Model.field], to couple data and fields array providing an
     * unified way to access data
     *
     * @param string $data
     *
     * @return void
     */
    public function normalize(&$data)
    {
        if (empty($data)) {
            return false;
        }
        $normalized = array();
        foreach ($data as $count => $row) {
            foreach ($this->fields as $column) {
                list($model, $field) = explode('.', $column);
                if (array_key_exists($model, $row)) {
                    if (array_key_exists($field, $row[$model])) {
                        $normalized[$count][$column] = $row[$model][$field];
                    }
                }
                if (array_key_exists($field, $row)) {
                    $normalized[$count][$column] = $row[$field];
                }
            }
        }
        $this->data = $normalized;

        return true;
    }

    /**
     * Prepares the array of column options, removes columns defined with null
     *
     * @param string $settings
     *
     * @return array
     */
    public function setColumns($settings = array())
    {
        if (!$settings) {
            $settings = $this->fields;
        }
        $this->Columns = array();
        foreach ($settings as $column => $options) {
            if (!is_string($column)) {
                $column = $options;
                $options = false;
            }
            if (!isset($options['display'])) {
                $options['display'] = true;
            }
            if (strpos($column, '.') === false && $column != 'actions') {
                $column = sprintf('%s.%s', $this->defaultModel, $column);
            }
            if (!isset($options['type'])) {
                if (isset($options['switch'])) {
                    $options['type'] = 'switch';
                } else {
                    $options['type'] = 'cell';
                }
            }
            $class = ucfirst($options['type']).'Column';
            $this->Columns[$column] = new $class($this, $column, $options);
        }
    }

    /**
     * Returns an array of HTML tags to build a header. Uses Paginator to create clickable
     * header to sort the data set
     * @return string with the HTML for headers
     */
    function headers()
    {
        // Maintain URL params for pagination
        if (empty($this->params['pass'])) {
            $this->params['pass'] = array();
        }
        $options = array(
            'url' => array_merge($this->tableOptions['url'], $this->params['named'], $this->params['pass']),
            //'model' => $this->defaultModel
        );
        if (!empty($this->tableOptions['ajax'])) {
            $options['update'] = $this->tableOptions['ajax']['mh-update'];
            $options['indicator'] = $this->tableOptions['ajax']['mh-indicator'];
            $options['before'] = $this->Js->get($options['indicator'])->effect('fadeIn', array('buffer' => false));
            $options['complete'] = $this->Js->get($options['indicator'])->effect('fadeOut', array('buffer' => false));
        }


        $this->Paginator->options($options);

        $lines = array();
        foreach ($this->Columns as $field => $Column) {
            $lines[] = $headerHTML[] = $Column->header();
        }

        $row = $this->Html->tag('tr', implode(chr(10), $lines));

        return $this->Html->tag('thead', $row);
    }

    /**
     * Build the table body
     *
     * @return void
     */
    public function body()
    {
        $this->altRow = false;
        $lastBreakValue = null;
        $body[] = '<tbody>';
        $breaks = 0;
        foreach ($this->data as $index => $row) {
            if (!empty($this->tableOptions['break'])) {
                $breakValue = $row[$this->tableOptions['break']];
                if ($breakValue !== $lastBreakValue) {
                    $lastBreakValue = $breakValue;
                    if ($breaks) {
                        $body[] = '</tbody>';
                        $body[] = '<tbody class="page-break-before">';
                    }
                    $breaks++;
                    $body[] = $this->buildBreakRow($this->tableOptions['break'], $row);
                    // continue;
                }
            }
            $body[] = $this->buildRow($row);
        }
        $body[] = '</tbody>';

        $ret = implode(chr(10), $body);

        if (!empty($this->tableOptions['totals'])) {
            $ret .= $this->buildTotalsRow();
        }

        return $ret;
    }

    /**
     * Builds a Break Row
     *
     * @param string $field
     * @param string $row
     *
     * @return void
     */
    public function buildBreakRow($field, &$row)
    {
        $content = $this->Columns[$field]->options['label'].': '.$row[$field];
        $cell = $this->Html->tag('td', $content, array('colspan' => count($this->Columns)));

        return $this->Html->tag('tr', $cell, array('class' => 'breakrow'));
    }

    /**
     * Builds a row of data
     *
     * @param array $row
     *
     * @return html
     */
    public function buildRow(&$row)
    {
        $lines = array();
        $class = '';
        foreach ($this->Columns as $field => $Column) {
            $lines[] = $Column->cell($row);
        }
        if ($this->tableOptions['group']) {
            $level = 1000;
            foreach ($this->tableOptions['group'] as $count => $group) {
                if (is_null($row[$group]) && $count < $level) {
                    $level = $count;
                }
            }
            if ($level < 1000) {
                $class = 'mh-table-group-row mh-table-group-row-level-'.$level;
            }

        }
        if (empty($class) && $this->altRow) {
            $class = 'altrow';
        }
        $this->altRow = !$this->altRow;

        return $this->Html->tag('tr', implode(chr(10), $lines), array('class' => $class));
    }

    /**
     * Builds a Totals Row (only supports sum)
     *
     * @return void
     */
    public function buildTotalsRow()
    {
        $line = '';
        foreach ($this->Columns as $field => $Column) {
            if (in_array($field, $this->tableOptions['totals'])) {
                $line .= $this->Html->tag('td', $Column->sum(), array('class' => 'cell-number'));
            } else {
                $line .= $this->Html->tag('td', ' ');
            }
        }

        return $this->Html->tag('tr', $line, array('class' => 'totalsrow'));
    }
	
	protected function _buildSelectionForm($code) {
		$f = $this->Form->create('_Selection', array(
			'class' => 'mh-inline-form',
			'url' => $this->tableOptions['selection']['url'],
			'onsubmit'=>'return confirm("'.__('Are you sure? This action affects several records and is no undoable.', true).'");'
			)
		);
		$selectionLabel = $this->Html->tag('label', __('Action to perform with selection', true), array('for' => '_SelectionAction'));

		$selectionField = $this->Form->select(
            '_Selection.action',
			$this->tableOptions['selection']['actions'],
			null,
			array(
			'empty' => __('-- Select an action --', true),
			'class' => 'selection-control'
			)
		);
		$submitButton = $this->Form->submit(__('Execute', true), array(
			'div' => false,
			'class' => 'mh-button mh-button-ok selection-control mh-btn-action-warning',
			'id' => '_SelectionExecute'
		));
		$fields = $this->Html->tag('div', $selectionLabel);
		$fields .= $this->Html->tag('div', $selectionField);
		$fields .= $this->Html->tag('div', $submitButton);
		$area = $this->Html->tag('div', $fields, array('class' => 'mh-admin-widget', 'id' => 'mh-table-selection-action'));
		$f .= $area;
		$f .= $code;
		$f .= $this->Form->end();
		return $f;
	}

	public function selectionWidget()
	{
		$code = $this->Form->create('_Selection', array(
			'class' => 'mh-backend-widget-form',
			'url' => $this->tableOptions['selection']['url'],
			'onsubmit'=>'return confirm("'.__('Are you sure? This action affects several records and is no undoable.', true).'");'
			)
		);
		$code .= $this->FForm->select('_Selection.action', array(
			'label' =>  __('Action to perform with selection', true),
			'options' => $this->tableOptions['selection']['actions'],
			'empty' => __('-- Select an action --', true),
			'class' => 'selection-control'
		)
        );


		$code .= $this->Form->submit(__('Execute', true), array(
			'div' => false,
			'class' => 'selection-control mh-btn-action-warning',
			'id' => '_SelectionExecute'
		));
		$code = $this->Html->div('mh-admin-widget', $code, array('id' => 'mh-table-selection-action'));
		return $code;
	}

	public function selectionForm()
	{
		if (empty($this->tableOptions['selection'])) {
			return;
		}
		return $this->_buildSelectionForm('');
	}

/**
 * Simplify data for the table
 *
 * @param string $data
 * @param string $options
 *
 * @return void
 */
	public function simplify($data, $options = array())
	{
		if (!$data) {
			return false;
		}

		if (empty($options['columns'])) {
			$options['columns'] = array();
		}

		// Set table Options
		if(!empty($options['table'])) {
			$this->tableOptions = array_merge($this->tableOptions, $options['table']);
			$this->tableOptions['attr']['class'] = $this->tableOptions['class'];
			$this->tableOptions['attr']['id'] = $this->tableOptions['id'];
			unset($options['table']);
        }

        // Get default model
		$this->defaultModel = $this->params['models'][0];
		if (!empty($this->tableOptions['model'])) {
			$this->defaultModel = $this->tableOptions['model'];
        }


		$this->setFields($data);
		// Set and normalize data for table
		$this->normalize($data);
		// Set and normalize visible columns
		$this->setColumns($options['columns']);
		return $this->data;
	}

/**
 * Builds an array with column labels to use as headers in a csv file
 *
 * @return void
 */
	public function csvHeaders()
	{
		$headers = array();
		foreach ($this->Columns as $field => $Column) {
			$headers[] = $Column->label();
		}
		return $headers;
	}

/**
 * returns data as a simple array or arrays to use them in a csv file or similar
 *
 * @return void
 */
	public function csvData()
	{
		$data = array();
		foreach ($this->data as $index => $row) {
			foreach ($this->Columns as $field => $Column) {
				$data[$index][] = $Column->value($row);
			}
		}
		return $data;
	}
	
/**
 * Helper to create the content of a toggle Cell for use in ajax responses
 *
 * @param string $value
 *
 * @return void
 */
	public function toggleCell($value = false) {
		if ($value) {
			return $this->Html->tag('span', '✔', array('class' => 'cell-boolean cell-boolean-true'));
		} 
		return $this->Html->tag('span', '✖', array('class' => 'cell-boolean cell-boolean-false'));
	}
}

/**
* Column
* 
* A table has many Columns. A Column renders header and cells for a column of data
* 
* All Column classes inherit from this
*/
class Column 
{
	var $options;
	var $Table;
	var $defaults = array(
		'label' => null,		// Text label for the cell, defaults to the name of the field
		'type' => 'cell', 		// cell, date, image, link, switch, size
		'field' => null,		// The field for the cell
		'sortable' => true,		// True to meke the column sortable clicking in its header or Field for sorting
		'ajax' => false,		// Ajax support
		'attr' => null,			// Extra HTML attributes for the cell, including class
		'empty' => null,		// What to show it the cell is empty or contains an empty equivalent value
		'format' => '%s',		// Format of the content of the cell
		'switch' => null,		// Values for switch fields
		'argField' => 'id', 	// If needed, what field use as argument, defaults to id
		'truncate' => false, 	// Truncate content to a certain number of characters
		'display' => true,		// Show this column or not
		'precision' => 2		// Default precision for numbers
		);
		
	var $field;
	var $value;

	function __construct(&$table, $field, $options = array()) {
		$this->Table = $table;
		$this->options = Set::merge($this->defaults, $options);
		$this->field = $field;
		
		// Create a label if it is not set
		if(!isset($this->options['label'])) {
			list($m, $f) = explode('.', $field);
			if ($m != $this->Table->defaultModel) {
				$f = sprintf('%s %s', $m, $f);
			}
			$label = trim($f);
			$this->options['label'] = __(Inflector::humanize($label), true);
		}
		// Normalize argument field if needed
		$argument = explode('.', $this->options['argField']);
		if (count($argument) == 1) {
			$model = $this->Table->defaultModel;
			$this->options['argField'] = sprintf('%s.%s', $model, $argument[0]);
		}
	}
		
	public function header() {
		if ($this->options['display'] == false) {
			return false;
		}
		$content = $this->options['label'];
		$attr = $this->options['attr'];
		if ($this->options['sortable']) {
			// Allows sorting by alternate fields, mainly for translated ones
			$sortField = $this->field;
			if (is_string($this->options['sortable'])) {
				$sortField = $this->options['sortable'];
			}
			// Modify the TH classes to show the column being sorted
			$newDirection = 'asc';
			if (isset($this->Table->params['named']['direction'])) {
				$direction = $this->Table->params['named']['direction'];
				$newDirection = ($direction =='asc' ? 'desc' : 'asc');
			}
			if (isset($this->Table->params['named']['sort']) && $this->Table->params['named']['sort'] == $this->field) {
				$class = $newDirection == 'asc' ? 'mh-sort-asc' : 'mh-sort-desc';
			} else {
				$class = 'mh-sort-undefined';
			}
			// Add the class attr
			if ($attr['class']) {
				$attr['class'] .= ' '.$class;
			} else {
				$attr['class'] = $class;
			}
			
			if (!empty($this->Table->tableOptions['ajax'])) {
				$sort['update'] = $this->Table->tableOptions['ajax']['mh-update'];
				$sort['indicator'] = $this->Table->tableOptions['ajax']['mh-indicator'];
				$sort['class'] = 'mh-ajax-btn-update';
			}
			
			$sort['direction'] = $newDirection;
			$content = $this->Table->Paginator->sort($this->options['label'], $sortField, $sort);
		}
		$code = $this->Table->Html->tag('th', $content, $attr);
		return $code;
	}
	
	public function label()
	{
		if ($this->options['display'] == false) {
			return false;
		}
		
		return $this->options['label'];
	}
		
	public function cell($row) {
		if ($this->options['display'] == false) {
			return false;
		}
		
		if ($this->field != 'actions') {
			list($model, $field) = explode('.', $this->field);
			$id = Inflector::Camelize($model.'_'.$field);
			if (isset($row[$this->options['argField']])) {
				$uid = $id.'_'.$row[$this->options['argField']];
				$this->options['attr']['id'] = $uid;
			}
		}
		$code = $this->Table->Html->tag('td', $this->value($row), $this->options['attr']);
		return $code;
	}
/**
 * Note: array data is converted to a comma separated string by default
 *
 * @param string $row
 *
 * @return void
 */	
	public function value($row) {
		$value = $row[$this->field];
		if (is_array($value)) {
			$value = $this->Table->Text->toList($value, __d('ui', 'and', true));
		}
		if (!empty($this->options['truncate'])) {
			$value = Sanitize::stripTags($value, 'img', 'object', 'embed', 'div', 'span');
			$value = $this->Table->Text->truncate($value, $this->options['truncate'], array('html' => true));
		}
		return $value;
	}
	
	public function sum()
	{
		$sum = 0;
		foreach ($this->Table->data as $row) {
			$sum += $row[$this->field];
		}
		return $sum;
	}
	
	public function max()
	{
		$max = null;
		foreach ($this->Table->data as $row) {
			if (!isset($max) || $row[$this->field] > $max) {
				$max = $row[$this->field];
			}
		}
		return $max;
	}

	public function min()
	{
		$min = null;
		foreach ($this->Table->data as $row) {
			if (!isset($min) || $row[$this->field] < $min) {
				$min = $row[$this->field];
			}
		}
		return $min;
	}

	
}

class CellColumn extends Column {
	
}

/**
* 
*/
class SelectionColumn extends Column
{
	
	function __construct(&$table, $field, $options = array()) {
		$this->Table = $table;
		$this->options = Set::merge($this->defaults, $options);
		$this->field = $this->Table->defaultModel.'.id';
		$this->options['attr']['class'] = 'cell-stretch no-print';
		// Create a label if it is not set
		if(!isset($this->options['label'])) {
			$this->options['label'] = __('Select', true);
		}
	}
	
	public function header($value='')
	{
		$content = $this->options['label'];
		$attr = $this->options['attr'];
		if (!empty($this->Table->tableOptions['selection']['all'])) {
			$content = $this->Table->Form->checkbox('Selection.all', array('id' => 'select-all'));
		}
		$code = $this->Table->Html->tag('th', $content, $attr);
		return $code;
	}
	
	function value($row)
	{
		list($theModel, $theField) = explode('.', $this->field);
		$checkbox = $this->field.'.'.$row[$this->field];
		$value = $this->Table->Form->checkbox($checkbox, array('class' => 'cell-select'));
		return $value;
	}
}



/**
 * Column for Time data
 *
 * Options:
 *
 * 'format' a standard format string for time
 */
class TimeColumn extends Column {
	public function value($row) {
		$value = $row[$this->field];
		if (!$value) {
			return false;
		}
		return $this->Table->Time->format($this->options['format'], $value);
	}
}

/**
 * Numeric columns
 *
 */
class NumberColumn extends Column {
	
	function __construct(&$table, $field, $options = array()) {
		parent::__construct($table, $field, $options);
		$this->options['attr']['class'] = 'cell-number cell-stretch';
	}
	
	public function value($row) {
		$value = $row[$this->field];
		if (!$value) {
			return false;
		}
		$format = array(
			'places' => $this->options['precision'],
			'decimals' => ',',
			'thousands' => '.',
			'before' => false,
			'after' => false
		);
		return $this->Table->Number->format($value, $format);
	}
}


class IntegerColumn extends NumberColumn {
	function __construct(&$table, $field, $options = array()) {
		parent::__construct($table, $field, $options);
		$this->options['precision'] = 0;
	}
	
}


/**
* Binary packed column
*
* Options:
* 
* 'format' array of 'bits' (2^n) => 'labels'
* 
*/
class BinaryColumn extends Column
{
	
	function value($row)
	{
		$value = $row[$this->field];
		$ret = array();
		foreach ($this->options['format'] as $bit => $label) {
			if ($value & $bit) {
				$ret[] = $label;
			} else {
				if (!empty($this->options['empty'])) {
					$ret[] = $this->options['empty'];
				}
			}
		}
		if (empty($this->options['toList'])) {
			$this->options['toList'] = __d('ui', 'and', true);
		}
		return $this->Table->Text->toList($ret, $this->options['toList']);
	}
}



/**
 * Columns for a switch value, similar to the switch structure. Allows to convert numeric code values to human readable ones.
 *
 * Options:
 *
 * 'switch' array of 'input value' => 'output value'
 *
 * @package default
 */
class SwitchColumn extends Column {
	public function value($row) {
		$value = $row[$this->field];
		if (is_null($value)) {
			$value = 0;
		}
		if(isset($this->options['switch'])) {
			if (!isset($this->options['switch'][$value])) {
				return false;
			}
			$value = $this->options['switch'][$value];
		}
		return $value;
	}
}


class StatusColumn extends Column {
	
	function __construct(&$table, $field, $options = array()) {
		parent::__construct($table, $field, $options);
		$this->options['attr']['class'] = 'cell-status cell-stretch';
	}
	
	public function value($row) {
		$value = $row[$this->field];
		if (is_null($value)) {
			$value = null;
		}
		if(isset($this->options['statuses'])) {
			if (!isset($this->options['statuses'][$value])) {
				$class = 'cell-status-undefined';
			} else {
				$class = "cell-status-".$this->options['statuses'][$value];
			} 
		}
		if (isset($this->options['switch'])) {
			if (!isset($this->options['switch'][$value])) {
				$value = '';
			} elseif (strlen($this->options['switch'][$value] > 1)) {
				$return = $this->Table->Html->tag('span','', array('class' => $class)).$this->options['switch'][$value];
			} else {
				$return = $this->Table->Html->tag('span',$this->options['switch'][$value], array('class' => $class));
			}
		}
		return $return;
	}
}


/**
* Allows to toggle a boolean value via ajax when you click on it. Need to provide a url (controller/action) to toggle the value
*/
class ToggleColumn extends Column
{
	public function value($row)
	{
		$value = $row[$this->field];
		$url = $this->options['url'];
		// Set cell values for ajax
		list($model, $field) = explode('.', $this->field);
		$uid = $field.'_'.$row[$this->options['argField']];
		$this->options['attr']['id'] = $uid;
		$this->options['attr']['class'] = 'cell-toggle cell-boolean';
		$url[] = $uid;
		if ($value) {
			$code = $this->Table->Html->tag('span', '✔', array('class' => 'cell-boolean-true'));
		} else {
			$code = $this->Table->Html->tag('span', '✖', array('class' => 'cell-boolean-false'));
		}
		$this->Table->Js->get('#'.$uid)->event('click',
			$this->Table->Js->request($url,array(
				'update' => '#'.$uid, 
				'before' => "$('#{$uid}').html('...')"
				)
			)
		);
		return $code;
	}
}

/**
 * Is a switch column than rotates between values when clicking on it (via ajax)
 * The column generates the ajax code and shows the actual value. You should provide a controller
 * action and a view that shows the current value
 *
 */
class RotateColumn extends Column
{
	public function value($row)
	{
		$value = $row[$this->field];
		if (is_null($value)) {
			$value = 0;
		}
		if(isset($this->options['switch'])) {
			if (!isset($this->options['switch'][$value])) {
				return false;
			}
			$value = $this->options['switch'][$value];
		}
		$url = $this->options['url'];
		// Set cell values for ajax
		list($model, $field) = explode('.', $this->field);
		$uid = $field.'_'.$row[$this->options['argField']];
		$this->options['attr']['id'] = $uid;
		$this->options['attr']['class'] = 'cell-rotate';
		$url[] = $uid;

		$this->Table->Js->get('#'.$uid)->event('click',
			$this->Table->Js->request($url,array(
				'update' => '#'.$uid, 
				'before' => "$('#{$uid}').html('...')" // acts as ajax-loader
				)
			)
		);
		return $value;
		// return $code;
	}
}




/**
 * Shows a green √ if value is true, or x if false
 * Useful to show boolean values given true state has a positive meaning
 * Relies on cell-boolean and cell-boolean-true css classes
 *
 * @package default
 */
class BooleanColumn extends Column {
	
	function __construct(&$table, $field, $options = array()) {
		parent::__construct($table, $field, $options);
		$this->options['attr']['class'] = 'cell-boolean cell-stretch';
	}
	
	public function value($row) {
		$value = $row[$this->field];
		if ($value) {
			return '<span class="cell-boolean-true">✔</span>';
		}
		return '<span class="cell-boolean-false">✖</span>';
	}
}

/**
 * Shows a red x if value is true, or √ green if false
 * Useful to show some error or wrong data in the data set
 * Relies on cell-boolean and cell-boolean-true css classes
 *
 * @package default
 */

class ErrorColumn extends Column {

	function __construct(&$table, $field, $options = array()) {
		parent::__construct($table, $field, $options);
		$this->options['attr']['class'] = 'cell-boolean cell-stretch';
	}

	public function value($row) {
		$value = $row[$this->field];
		if (!$value) {
			return '<span class="cell-boolean-true">✔</span>';
		}
		return '<span class="cell-boolean-false">✖</span>';
	}
}



class ActionsColumn extends Column {
	var $defaults = array(
		'label' => 'Actions',
		'type' => 'cell', // cell, date, image, link, switch, size
		'field' => null,
		'sortable' => false,
		'ajax' => false,
		'attr' => array(),
		'empty' => null,
		'format' => '%s',
		'switch' => null,
		'argField' => 'id', // If needed, what field use as argument
		'actions' => array(),
		'mode' => null
		);

	var $field = null;
	
	var $actionDefaults = array(
		'label' => false,
		'argField' => 'id',
		'url' => array(),
		'icon' => false,
		'template' => ':label', // Supports icon and label
		'confirm' => false,
		'switch' => false, // Change the URL of the action based on values on field switchField
		'switchField' => false
		);
		
	var $actionsAjaxClasses = array(
		'edit' => 'reveal',
		'delete' => 'update'
	);
		
	public function __construct(&$table, $field, $options = array())
	{
		parent::__construct($table, $field, $options);
		$this->normalizeActions();
		$this->options['attr']['class'] = 'actions';
		$this->options['label'] = __('Actions', true);
		
	}
	
	public function normalizeActions() {
		$actions = array();
		foreach ($this->options['actions'] as $action => $options) {
			if (!$action) {
				$action = $options;
				$options = array();
			}
			if (!empty($options['switch'])) {
				$result = $this->_normalizeSwitchAction($action, $options);
				$actions[$action] = $result;
				continue;
			}
			$actions[$action] = $this->_normalizeAction($action, $options);
		}
		$this->options['actions'] = $actions;
	}

    protected function _normalizeSwitchAction($action, $options)
    {
        $actions = array();
        foreach ($options['actions'] as $actionName => $actionOptions) {
            $actions[$actionName] = $this->_normalizeAction($actionName, $actionOptions);
        }
        $options['actions'] = $actions;

        return $options;
    }
	
	protected function _normalizeAction($action, $options) {
		if (is_numeric($action)) {
			unset($this->options['actions'][$action]);
			$action = $options;
			$options = array();
		}
		$options = array_merge($this->actionDefaults, $options);
		// Automagic for some options
		if (empty($options['label'])) {
			$options['label'] = ucfirst($action);
		}
		if (strpos($options['argField'], '.') === false) {
			$options['argField'] = $this->Table->defaultModel.'.'. $options['argField'];
		}
		if (empty($options['url'])) {
			$options['url'] = array(
				'action' => $action
				);
		}
		// Add pagination data to the action url, needed for ajax actions
		// Coupled with XFormHelper->ajaxSend()
		$extract = array('page' => true, 'sort' => true, 'direction' => true);
		$pagination = array_intersect_key($this->Table->params['named'], $extract);
		if (!empty($pagination)) {
			$options['url'] = array_merge($options['url'], $pagination);
        }

		if (empty($options['icon']) && file_exists(IMAGES.'icons'.DS.$action.'_32.png')) {
			$options['icon'] = 'icons'.DS.$action.'_32.png';
		}
		if (!empty($options['icon'])) {
			$options['icon'] = $this->Table->Html->image($options['icon']);
		}
		return $options;
	}
	
	public function value($row)
	{
		$code = array();
		foreach ($this->options['actions'] as $action => $options) {
			if (!empty($options['switch'])) {
				$code[] = $this->_buildSwitchActionButton($action, $options, $row);
				continue;
			}
			$code[] = $this->_buildActionButton($action, $options, $row);
		}
		return implode(' ', $code);
	}

    /**
     * Builds the button for a Switch Action
     * 'default' option allows a "fallback" for values that has no explicit action, i.e.
     * when you has multiple values but only two alternative options
     *
     * @param string $action
     * @param string $options
     * @param string $row
     *
     * @return void
     * @author Frankie
     */
    protected function _buildSwitchActionButton($action, $options, $row)
    {
        $trigger = $row[$options['switchField']];
        if (!isset($options['switch'][$trigger])) {
            $trigger = $options['default'];
        }
        $actionName = $options['switch'][$trigger];
        if (!isset($options['actions'][$actionName])) {
            return false;
        }
        $actionOptions = $options['actions'][$actionName];

        return $this->_buildActionButton($actionName, $actionOptions, $row);
    }

	protected function _buildActionButton($action, $options, $row) {
		$attr = '';
		if (!empty($options['attr'])) {
			$attr = $options['attr'];
		}
		if (!empty($options['icon'])) {
			$attr['escape'] = false;
			//$options['template'] = ':icon';
        }

		if (empty($attr['class'])) {
			$attr['class'] = 'mh-btn-'.$action;
		}
		$attr['class'] = 'mh-btn-action '.$attr['class'];

        $label = trim(CakeString::insert($options['template'], $options));

		if (!empty($options['switch'])) {
			$newUrl = $options['switch'][$row[$options['switchField']]];
			$options['url'] = array_merge($options['url'], $newUrl);
		}
		$url = $options['url'];
		$url[] = $row[$options['argField']];

		if (!empty($options['ajax'])) {
			$attr['mh-indicator'] = $options['ajax']['mh-indicator'];
			$attr['mh-update'] = $options['ajax']['mh-update'];
			$ajaxClass = 'reveal';
			if (!empty($this->actionsAjaxClasses[$action])) {
				$ajaxClass = $this->actionsAjaxClasses[$action];
			}
			$attr['class'] .= ' mh-ajax-btn-'.$ajaxClass;
			$attr['id'] = 'mh-ajax-btn-'.$action.'-'.$row[$options['argField']];
        }

		return $this->Table->Html->link($label, $url, $attr, $options['confirm']);
	}

}


/**
 * Link column uses the field as label for a internal link, with
 * 
 * url => the basic url to link
 * argField => the argument to pass to the url
 *
 * @package default
 */
class LinkColumn extends Column {
	
	function __construct(&$table, $field, $options = array()) {
		parent::__construct($table, $field, $options);
		if (!empty($this->options['attr']['class'])) {
			$this->options['attr']['class'] = 'cell-link '.$this->options['attr']['class'];
		} else {
			$this->options['attr']['class'] = 'cell-link';
		}
	}
	
	public function value($row) {
		if (isset($this->options['url'])) {
			$url = $this->options['url'];
		}
		$attr = array();
		if (!empty($this->options['attr']['target'])) {
			$attr['target'] = $this->options['attr']['target'];
		}
		$url[] = $row[$this->options['argField']];
		$value = $this->Table->Html->link($row[$this->field], $url, $attr);
		return $value;
	}
}


class CompactColumn extends Column {
	
	function __construct(&$table, $field, $options = array()) {
		parent::__construct($table, $field, $options);
	}
	
	public function value($row) {
		if (!isset($this->options['extra'])) {
			return $row[$this->field];
		}
		$value = $row[$this->field];
		foreach ((array)$this->options['extra'] as $field) {
			$partial = $this->Table->Html->tag('small', $row[$field]);
			$value .= ' '.$partial;
		}
		return $value;
	}
}


/**
 * Url column uses the field to create a link to an external url
 * 
 * 'text' option to use another field as label for the link
 *
 * @package default
 */
class UrlColumn extends Column {
	public function value($row) {
		if (!empty($this->options['text'])) {
			$label = $row[$this->options['text']];
		} else {
			$label = $row[$this->field];
		}
		$value = $this->Table->Html->link($label, $row[$this->field]);
		return $value;
	}
}

/**
 * Shows the image in a field
 *
 * @package default
 */
class ImageColumn extends Column {
	public function value($row) {
		$value = $row[$this->field];
		if (!$value) {
			return false;
		}
		return $this->Table->Media->image($value, array('size' => 'tableImageCell'));
	}
}


/**
 * Shows preview of a file
 *
 * @package default
 */
class PreviewColumn extends Column {
	public function value($row) {
		$value = $row[$this->field];
		if (!$value) {
			return false;
		}
		return $this->Table->Media->preview($value, 'tablePreviewCell');
	}
}



/**
 * Shows a human readable file size
 *
 * @package default
 */
class SizeColumn extends Column {
	public function value($row) {
		$value = $row[$this->field];
		return $this->Table->Number->toReadableSize($value);
	}
}

/**
 * Basic days column. Value is a binary packed week days where:
 *
 *	monday    =  1,
 *  tuesday   =  2,
 *	wednesday =  4,
 *	thursday  =  8,
 *  friday    = 16,
 *  saturday  = 32,
 *	sunday    = 64
 *
 * @package default
 */
class DaysColumn extends BinaryColumn {
	
	public function value($row)
	{
		$full = array(
			1 => __('monday', true),
			2 => __('tuesday', true),
			4 => __('wednesday', true),
			8 => __('thursday', true),
			16 => __('friday', true),
			32 => __('saturday', true),
			64 => __('sunday', true)
		);
		
		$compact = array(
			1 => __('mo', true),
			2 => __('tu', true),
			4 => __('we', true),
			8 => __('th', true),
			16 => __('fr', true),
			32 => __('sa', true),
			64 => __('su', true)
		);
		
		$list = $full;
		if (strpos($this->options['mode'], 'compact') !== false) {
			$list = $compact;
		}
		
		if (strpos($this->options['mode'], 'labor') !== false) {
			unset($list[32]);
			unset($list[64]);
		}
		$this->options['format'] = $list;
		// $this->options['empty'] = '--';
		$this->options['toList'] = ',';
		return parent::value($row);
	}
}

?>
