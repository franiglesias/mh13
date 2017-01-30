<fieldset>
	<legend><?php __d('cantine', 'Student data'); ?></legend>
	<?php echo $this->Form->input('Student.id', array('type' => 'hidden')); ?>
	<div class="row">
		<?php
		echo $this->FForm->input('Student.Section.title', array(
			'readonly' => true, 
			'label' => __d('cantine', 'Section', true),
			'div' => 'medium-3 columns'
			));
		echo $this->FForm->days('Student.extra1', array(
			'format' => 'labor',
			'label' => __d('school', 'Extra1', true),
			'div' => 'medium-7 columns'
			));
		echo $this->FForm->checkbox('Student.extra2', array(
			'label' => __d('school', 'Extra2', true),
			'div' => 'medium-2 columns'
		));
		?>
	</div>
	<div class="row">
		<?php echo $this->FForm->textarea('Student.remarks', array(
			'label' => __d('cantine', 'Remarks', true)
		));
		?>
	</div>
</fieldset>
