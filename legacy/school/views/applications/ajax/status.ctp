<?php $this->Application->bind($this->data); ?>
<?php $this->Form->create('Application'); ?>
<fieldset>
	<legend><?php __d('school', 'Application status'); ?></legend>
	<div class="row">
		<?php
		echo $this->FForm->select('status', array(
			'label' => __d('school', 'Status', true),
			'options' => $this->Application->statuses,
			'readonly' => true,
			'div' => 'medium-2 columns'
		));
		App::import('Helper', 'presentation_model/TransitionBuilder');
		$Builder = new TransitionBuilder($this->Application);
		echo $Builder->render('status', 'medium-4 columns', '#tabs-2', '#application-transitions');
		// echo $this->Application->transitions('medium-4 columns');
		echo $this->FForm->date('interview', array(
			'label' => __d('school', 'Interview date', true),
			'clearable' => true,
			'div' => 'medium-3 columns'
		));
		echo $this->FForm->select('resolution', array(
			'label' => __d('school', 'Resolution', true),
			'options' => $this->Application->resolutions,
			'value' => $this->Form->value('resolution'),
			'readonly' => true,
			'div' => 'medium-3 columns end'
		));
		?>
	</div>
</fieldset>
