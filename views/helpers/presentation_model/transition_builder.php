<?php

class TransitionBuilder
{
	protected $PM;
	function __construct(PresentationModel $PM)
	{
		$this->PM = $PM;
	}
	
	public function render($field, $class, $domId, $indicator)
	{
		$data = $this->PM->getTransitionData($field);
		$code = '<label>' . __('Available actions', true) . '</label>';
		foreach ($data as $button) {
			$code .= $this->button($button, $domId, $indicator);
		}
		return sprintf('<div class="%s">%s</div>', $class, $code);
	}
	
	protected function button($button, $domId, $indicator)
	{
		return $this->PM->Html->link(
			$button['label'],
			array('action' => $button['action'], $this->PM->value('id')),
			array(
				'class' => 'mh-ajax-button '.$button['class'],
				'mh-indicator' => $indicator,
				'mh-update' => $domId,
			)
		);
	}
}


?>