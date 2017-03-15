<?php
class StudentsController extends SchoolAppController {

	var $name = 'Students';
	var $layout = 'backend';
	
	var $components = array(
		'Filters.SimpleFilters'
	);

	public function beforeFilter()
	{
		parent::beforeFilter();
		// $this->SimpleFilters->setSwapFilters(array(
		// 	'Student.extra1' => array(
		// 		'1' => array(
		// 			'label' => __d('school', 'Without extra', true),
		// 			'conditions' => array('Student.extra1' => 0)
		// 			),
		// 		'2' => array(
		// 			'label' => __d('school', 'With extra', true),
		// 			'conditions' => array('Student.extra1 !=' => 0)
		// 			)
		// 	)));
		$this->Auth->allow('autocomplete', 'basic');
	}

	function index() {
		
		$this->Student->recursive = 0;
		$sections = $this->Student->Section->find('list');
		$this->set(compact('sections'));
		$this->set('students', $this->paginate());
		$this->set('levels', $this->Student->Section->Level->find('list'));
		$this->set('cycles', $this->Student->Section->Cycle->find('list'));
	}

	function add() {
		$this->setAction('edit');
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			if (!$id) {
				$this->Student->create(); // 2nd pass
			}
			// Try to save data, if it fails, retry
			if (empty($this->data['Student']['extra1'])) {
				$this->data['Student']['extra1'] = 0;
			}
			if (empty($this->data['Student']['extra2'])) {
				$this->data['Student']['extra2'] = 0;
			}
			if ($this->Student->save($this->data)) {
                $this->Session->setFlash(
                    sprintf(__('The %s has been saved.', true), __d('school', 'Student', true)),
                    'success'
                );
				$this->xredirect();
			} else {
                $this->Session->setFlash(
                    sprintf(__('The %s could not be saved. Please, try again.', true), __d('school', 'Student', true)),
                    'warning'
                );
			}
		}
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Student->read($fields, $id))) {
                    $this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('school', 'Student', true)), 'alert');
					$this->xredirect();
				}
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
		$sections = $this->Student->Section->find('list');
		$this->set(compact('sections'));
	}
	
	public function basic($id = null)
	{
		if (empty($this->data)) { // 1st pass
			if ($id) {
				$fields = null;
				if (!($this->data = $this->Student->read($fields, $id))) {
                    $this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('school', 'Student', true)), 'alert');
					$this->xredirect();
				}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
			}
		}
	}
	
	public function autocomplete()
	{
		if (!empty($this->params['url']['term'])) {
			$term = $this->params['url']['term'];
		}
		$return = array();
		foreach ($this->Student->autocomplete($term) as $id => $fullname) {
			$return[] = array(
				'value' => $id,
				'label' => $fullname
			);
		}
		$this->set(compact('return'));
		$this->render('ajax/autocomplete', 'ajax');
	}
	
}
?>