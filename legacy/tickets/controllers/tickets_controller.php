<?php
class TicketsController extends TicketsAppController {

	var $name = 'Tickets';
	var $layout = 'backend';
	var $components = array('Filters.SimpleFilters');
	var $helpers = array('Ui.Table');
	
	var $filters = array(
		'all',
		'pending',
		'expired',
		'used'
		);
	
	/**
	 * Controller beforeFilter callback.
	 * Called before the controller action. 
	 * 
	 * @return void
	 */
	function beforeFilter() {
		parent::beforeFilter();
		$this->defaultFilter = array(
			'Ticket.filter' => 'pending'
		);
	}
	

/**
 * See all tickets, filtered by
 * 
 * all:		all tickets in the db
 * pending:	all tickets that are not expired and not used
 * expired:	all tickets that are both expired and not used
 * used:    all tickets that were used
 * 
 * No filter or invalid filter defaults to pending
 *
 * @return void
 */
	public function index() {
		$current = $this->SimpleFilters->getFilter('Ticket.filter');
		
		if (is_null($current)) {
			$filter = 'pending';
		} elseif (!$current) {
			$filter = 'all';
		} else {
			$filter = $current;
		}
		
		$this->SimpleFilters->setFilter('Ticket.filter', $filter);
		$this->paginate['Ticket'][0] = $filter;
		// Remove conditions injected by Filter component
		unset($this->paginate['Ticket']['conditions']);
		$tickets = $this->paginate('Ticket');
		$this->set(compact('tickets'));
	}

/**
 * Deletes a certain ticket
 *
 * @param string $id
 *
 * @return void
 */
	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Ticket', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->Ticket->id = $id;
		
		if(!$this->Ticket->delete()) {
            $this->Session->setFlash(__('Invalid Ticket', true), 'alert');
		} else {
            $this->Session->setFlash(__('Ticket deleted', true), 'success');
		}
		
		$this->redirect(array('action' => 'index'));
		
	}
	
/**
 * Purges all used and expired tickets
 *
 * @return void
 */
	public function purge() {
		$conditions = array(
			'or' => array(
				'Ticket.expiration < CURDATE()',
				'Ticket.used' => 1
				)
			);
		if($this->Ticket->deleteAll($conditions)) {
            $this->Session->setFlash(__('Data purged', true), 'success');
		} else {
            $this->Session->setFlash(__('No changes', true), 'alert');
		}
		$this->redirect(array('action' => 'index'));
	}
}

?>
