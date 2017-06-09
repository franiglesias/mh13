<div class="content" id="tabs-2">
	<fieldset>
		<legend><?php __d('circulars', 'Meeting details'); ?></legend>
		<p><?php __d('circulars', 'This details will be showed in the events calendar'); ?></p>
		
		<div class="row">
			<?php
				echo $this->FForm->date('Event.startDate', array(
					'label' => __d('circulars', 'Start Date', true),
					'error' => array(
						'notEmpty' => sprintf(__d('circulars', 'Provide a date for this %s', true), __d('circulars', 'meeting', true))
					),
					'clearable' => true,
					'div' => 'medium-3 columns'
				));
				echo $this->FForm->time('Event.startTime', array(
					'interval' => 5,
					'timeFormat' => 24,
					'label' => __d('circulars', 'Start Time', true),
					'div' => 'medium-2 columns'
				));
				echo $this->FForm->time('Event.endTime', array(
					'interval' => 5,
					'timeFormat' => 24,
					'label' => __d('circulars', 'End Time', true),
					'div' => 'medium-2 columns end'
				));
			?>
		</div>
		<div class="row">
			<?php echo $this->Multilingual->element('circulars/meeting/event', array('plugin' => 'circulars')); ?>
		</div>
		
		<?php echo $this->Form->input('Event.id'); ?>
	</fieldset>
	<div class="row">
		<?php echo $this->Multilingual->element('circulars/form/details', array('plugin' => 'circulars')); ?>
	</div>

</div>