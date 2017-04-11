<?php
/**
 * SimpleFiltersComponent
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class SimpleFiltersComponent extends Object {

	var $controller;	// The controller that loads this component
	var $model;			// The main model from the controller $controller->modelClass
	var $filter;		// Contains the filter data
	
/**
 * $types (array)
 *
 *	Filter_type => family of filters
 */
	var $types = array(
		'equal'		=> 'equal',
		'from'		=> 'range',
		'to'		=> 'range',
		'not'		=> 'exclude',
		'binary'	=> 'binary',
		'starts'	=> 'string',
		'ends'		=> 'string',
		'contains'	=> 'string',
		'nstarts'	=> 'string',
		'nends'		=> 'string',
		'ncontains'	=> 'string',
	);
	
	var $ignore = array(
		'-alt$'				// Remove -alt fiels (example: date fields with alternate format)
	);
	
	/**
	 * Called before the Controller::beforeFilter().
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function initialize(&$controller, $settings = array()) {
		if (!isset($this->__settings[$controller->name])) {
			$this->__settings[$controller->name] = $settings;
		}
		$this->controller = &$controller;
	}

	/**
	 * Called after the Controller::beforeFilter() and before the controller action
	 * automatically loads the SimpleFilterHelper and looks for filter info in data
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function startup(&$controller) {
		$this->controller = $controller;
		$controller->helpers[] = 'Filters.SimpleFilter';
		$this->apply();
	}

	/**
	 * Looks for filter data in the controller->data array, checks if reset filter button was pressed
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function apply() {
		$this->filter = array();
		// Compute current url to use as key to store data in session
		$key = $this->_computeSessionKey();
		// Filter applies to main model
		$this->model = $this->controller->modelClass;
		// Reset Filter
		if (!empty($this->controller->params['form']['FilterReset'])) {
			// Pasar esto a un método que también controle los valores por defecto configurados en el controller
			unset($this->controller->data['_Filter']);
			unset($this->controller->params['form']['FilterReset']);
			if (!empty($this->controller->defaultFilter)) {
				foreach ($this->controller->defaultFilter as $filter => $value) {
					$this->setFilter($filter, $value);
				}
			}
			$this->controller->Session->delete($key);
			return;
		}
		// If there are no filter data for this view and session key, do nothing
		if (empty($this->controller->data['_Filter']) && $this->controller->Session->check($key) == false) {
			return;
		}
		// Prepares the filter array in $this->filter with data retrieved from controller or session
		$this->_loadFilter($key);
		if (empty($this->filter)) {
			return;
		}
		$conditions = $this->processFilters();
		// Pass conditions to paginate array
		$this->injectConditions($conditions);
	}

    /**
     * Computes the key to store filter data in the Session
     *
     * @return string The Key
     */
    protected function _computeSessionKey()
    {
        // Compute current url to use as key for store data in session
        $urlComponents = array_intersect_key(
            $this->controller->params,
            array('plugin' => true, 'controller' => true, 'action' => true)
        );
        $key = 'Filter.';
        $key .= !empty($urlComponents['plugin']) ? $urlComponents['plugin'].'/' : '';
        $key .= $urlComponents['controller'].'/'.$urlComponents['action'];

        return $key;
    }

    /**
     * Load existing data for filter. Remove unused and invalid filters
     *
     * @param string $key Session key
     *
     * @return void Populates filter property
     */
    protected function _loadFilter($key)
    {
        // Retrieve data from Session if no data is sent in Form, and pass them to the form via controller->data
        if (empty($this->controller->data['_Filter'])) {
            $this->filter = $this->controller->Session->read($key);
            $this->controller->data['_Filter'] = $this->filter;
        } else {
            $this->_cleanFilterData();
            $this->filter = $this->controller->data['_Filter'];
            // Store data in Session
            $this->controller->Session->write($key, $this->filter);
        }
    }

    /**
     * Removes empty or invalid filters from controller data array
     */
    protected function _cleanFilterData()
    {
        if (!empty($this->ignore)) {
            $ignorePattern = '/'.implode('|', $this->ignore).'/';
        }
        $filters = $this->controller->data['_Filter'];
        foreach ($filters as $model => $fields) {
            foreach ($fields as $field => $data) {
                foreach ($data as $filter => $value) {
                    if ($this->_filterEmpty(array($filter => $value))) {
                        unset($this->controller->data['_Filter'][$model][$field][$filter]);
                    }
                    if (!empty($this->ignore) && preg_match($ignorePattern, $field) !== 0) {
                        unset($this->controller->data['_Filter'][$model][$field][$filter]);
                    }
                }
                if (empty($this->controller->data['_Filter'][$model][$field])) {
                    unset($this->controller->data['_Filter'][$model][$field]);
                }
            }
            if (empty($this->controller->data['_Filter'][$model])) {
                unset($this->controller->data['_Filter'][$model]);
            }
        }
    }

    /**
     * Checks if a filter has no value
     *
     * @param string $data
     *
     * @return boolean true if Filter is empty
     * @author Fran Iglesias
     */
    protected function _filterEmpty($data)
    {
        $value = array_pop($data);
        if (!is_numeric($value)) {
            return $value !== 0 && empty($value);
        } elseif ($value == 0) {
            return false;
        }
    }

	protected function processFilters()
	{
		$filters = $this->controller->postConditions($this->filter);
		$conditions = array();
		foreach ($filters as $field => $data) {
			$type = $this->_filterType($data);
			if ($this->_filterEmpty($data)) {
				continue;
			}
			$field = $this->_checkForVirtualFields($field);
			switch ($type) {
				case 'range':
					$result = $this->_filterRange($field, $data);
					$conditions[key($result)] = array_pop($result);
					break;
				case 'exclude':
					$conditions[$field.' !='] = $data['not'];
					break;
				case 'equal':
					$conditions[$field.' ='] = $data['equal'];
					break;
				case 'string':
					$result = $this->_filterString($field, $data);
					$conditions[key($result)] = array_pop($result);
					break;
				case 'binary':
					break;
				default:
					$conditions[$field] = array_pop($data);
					break;
			}
			if (!empty($data['equal'])) {
				continue;
			}
		}
		return $conditions;
	}

    /**
     * Detects the type of filter
     *
     * @param string $data
     *
     * @return void
     * @author Fran Iglesias
     */
    protected function _filterType($data)
    {
        if (count($data) == 1) {
            $filter = key($data);
            if (isset($this->types[$filter])) {
                return $this->types[$filter];
            }

            return false;
        }
        $theFilter = array();

        foreach ($data as $filter => $value) {
            if (in_array($filter, array_keys($this->types))) {
                $theFilter[$filter] = $value;
            }
        }

        if (!count($theFilter)) {
            return false;
        }

        if (count($theFilter) == 1) {
            $type = $this->_filterType($theFilter);

            return $type;
        }

        return 'range';
    }

    /**
     * Checks if a field is Virtual Field, if so, it replaces the field name with the definition
     *
     * @param string $field
     *
     * @return string field definition if found, otherwise the field name
     */
    protected function _checkForVirtualFields($field)
    {
        list($theModel, $theField) = explode('.', $field);
        $definition = false;
        if ($theModel == $this->controller->modelClass) {
            $definition = $this->controller->{$theModel}->getVirtualField($theField);
        } elseif (in_array(
            $theModel,
            array_keys($this->controller->{$this->controller->modelClass}->getAssociated())
        )) {
            $definition = $this->controller->{$this->controller->modelClass}->{$theModel}->getVirtualField($theField);
        }
        if ($definition) {
            return $definition;
        }

        return $field;
    }

    /**
     * Specific methods to process some types of filters
     *
     * @param string $field
     * @param string $data
     */
    protected function _filterRange($field, $data)
    {
        $conditions = array();
        extract($data);
        if (!empty($from) && !empty($to)) {
            $conditions[$field.' BETWEEN ? AND ?'] = array($from, $to);

            return $conditions;
        }
        if (!empty($from)) {
            $conditions[$field.' >='] = $from;

            return $conditions;
        }
        if (!empty($to)) {
            $conditions[$field.' <='] = $to;
        }

        return $conditions;
    }

    protected function _filterString($field, $data)
    {
        $filter = key($data);
        $value = $data[$filter];

        if ($filter[0] == 'n') {
            $operator = $field.' NOT LIKE';
            $filter = substr($filter, 1);
        } else {
            $operator = $field.' LIKE';
        }

        switch ($filter) {
            case 'starts':
                return array($operator => $value.'%');
                break;
            case 'ends':
                return array($operator => '%'.$value);
                break;
            default:
                return array($operator => '%'.$value.'%');
                break;
        }

        return false;
    }

/**
 * Pass filter data to the paginate array under conditions key
 */
	protected function injectConditions($conditions)
	{
		foreach ($conditions as $key => $value) {
			$this->controller->paginate[$this->model]['conditions'][$key] = $value;
		}

		if (empty($this->controller->paginate[$this->model]['conditions'])) {
			$this->controller->paginate[$this->model]['conditions'] = array();
		}
	}

    /**
     * Called after the Controller::beforeRender(), after the view class is loaded, and before the
     * Controller::render()
     *
     * @param object  A reference to the controller
     *
     * @return void
     * @access public
     */
    function beforeRender(&$controller)
    {
	}

/**
 * Change the value of the filter only if the filter has a null value
 *
 * @param string $field
 * @param string $value
 * @param string $type
 * @param string $url
 */
	public function setFilterIfNull($field, $value, $type = 'equal', $url = null)
	{
		if (!is_null($this->getFilter($field))) {
			return;
		}
		$this->setFilter($field, $value, $type, $url);
	}

/**
 * Gets the value of a filter
 *
 * @param string $field
 *
 * @return void
 */
	public function getFilter($field = null)
	{
		if (empty($field)) {
			return $this->controller->data['_Filter'];
        }

		if (!empty($this->ignore)) {
			$ignorePattern = '/'.implode('|', $this->ignore).'/';
        }

		list($modelName, $fieldName) = explode('.', $field);
		if (!isset($this->controller->data['_Filter'][$modelName][$fieldName])) {
			return null;
        }

		$getFilters = $this->controller->data['_Filter'][$modelName][$fieldName];

		if (count($getFilters) > 1) {
			foreach ($getFilters as $filter => $value) {
				if (in_array($filter, array_keys($this->types))) {
					$theFilter[$filter] = $value;
				}
			}
			$getFilters = $theFilter;
        }

		if (count($getFilters) == 1) {
			$theFilter = $getFilters;

			$type = key($theFilter);

			if (!empty($theFilter[$type])) {
				return $theFilter[$type];
			}

			if (is_null($theFilter[$type])) {
				return null;
			}

			if (is_numeric($theFilter[$type])) {
				return 0;
			}
			return false;
		}

		return $theFilter;
    }

    /**
     * Programatically assigns a value to a filter and reapplies
     *
     * @param string $field The filter field
     * @param string $value The new value
     * @param string $type  (equal)
     * @param string $url
     */
    public function setFilter($field, $value, $type = 'equal', $url = null)
    {
        if (!in_array($type, array_keys($this->types))) {
            $url = $type;
            $type = 'equal';
        }
        if (!empty($url)) {
            $this->setUrl($url);
        }
        list($modelName, $fieldName) = explode('.', $field);
        $this->controller->data['_Filter'][$modelName][$fieldName][$type] = $value;
        $this->apply();
    }

/**
 * When setting filters with setFilter you should provide a URL where the filter will be applied if different
 * from the current action, i.e.: set filter at the end of a edit action, that should be applied in the index.
 *
 * So, perform this:
 *
 * function edit($id = null) {
 *	.....
 *	// just before redirect to index
 *
 * 	$this->SimpleFilter->setUrl(array('action' => 'index'));
 * 	$this->SimpleFilter->setFilter('name', 'lastname');
 *  $this->redirect();
 *
 *
 *}
 *
 *
 * @param array $url (plugin, controller and action component supported)
 *
 * @return void
 */
	public function setUrl($url) {
		$components = array(
			'plugin',
			'controller',
			'action'
		);
		foreach ($components as $component) {
			if (isset($url[$component])) {
				$this->controller->params[$component] = $url[$component];
			}
		}
	}


}

?>
