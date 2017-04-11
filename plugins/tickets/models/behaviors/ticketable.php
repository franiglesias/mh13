<?php
/**
 * Ticketable Behavior
 * 
 * Adds tickets support to enable actions
 *
 * @package tickets.milhojas
 * @version $Rev$
 * @license MIT License
 * 
 * $Id$
 * 
 * $HeadURL$
 * 
 **/


App::import('Model', 'Ticket');


class TicketableBehavior extends ModelBehavior {

/**
 * Contains configuration settings for use with individual model objects.
 * Individual model settings should be stored as an associative array, 
 * keyed off of the model name.
 *
 * @var array
 * @access public
 * @see Model::$alias
 */
	var $settings = array(
		'expiration' => '+2 week'
		);


/**
 * Initiate Ticketable Behavior
 *
 * @param object $model
 * @param array $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		$this->settings = array_merge($this->settings, $config);

	}
/**
 * Creates a new ticket associated with the model record and returns the ticket Id
 *
 * @param string $model
 * @param string $action
 * @param string $id
 *
 * @return void
 */
	function createTicket(&$model, $action, $id = null) {
		$model->setId($id);
        $ticket = ClassRegistry::init('Ticket');
		return $ticket->init($model, $action, $this->settings['expiration']);
	}
	
/**
 * Pass a ticket ID and execute model->{$action} if ticket exists and expiration
 * date is no exceeded, if model->{$action} doesn't exist return true. 
 * Sets the model->id property to the foreign_key provided
 *
 * @param string $model
 * @param string $ticketId
 *
 * @return boolean
 */	
	function redeemTicket(&$model, $ticketId) {
        $ticket = ClassRegistry::init('Ticket');
		return $ticket->redeem($model, $ticketId);
	}

	public function keepTicket(&$model, $ticket)
	{
		$model->ticket = $ticket;
	}
	
	public function useTicket(&$model)
	{
		$tmp = $model->ticket;
		unset($model->ticket);
		return $tmp;
	}
} // End of TicketableBehavior

?>
