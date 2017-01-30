<?php

/**
* 
*/
class OwnerHelper extends AppHelper
{
	var $helpers = array('Html', 'Js');
	
	public function script($options = array()) {
		$defaults = array(
			'Url' => array(
				'bind' => Router::url(array(
		        	'plugin' => 'access',
					'controller' => 'ownerships',
					'action' => 'bind'
		        )),
				'unbind' => Router::url(array(
		        	'plugin' => 'access',
					'controller' => 'ownerships',
					'action' => 'unbind'
		        )),
				'rebind' => Router::url(array(
		        	'plugin' => 'access',
					'controller' => 'ownerships',
					'action' => 'rebind'
		        ))
			)
		);
		$owVars = Set::merge($defaults, $options);
		echo $this->Html->scriptBlock('var owVars = '.$this->Js->object($owVars).';');
	}
}



?>
