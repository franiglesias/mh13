<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	$this->FForm->defaults['inputSize'] = 10;
?>
<section id="cantineIncidences-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'CantineIncidence', 'cantine', $this->Form->value('CantineIncidence.id'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CantineIncidence');?> 
			<fieldset>
			<legend><?php __d('cantine', 'CantineIncidence Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
					if (!empty($this->data['CantineIncidence']['id'])) {
						echo $this->Form->input('id');
						echo $this->FForm->text('Student.fullname', array(
							'label' => __d('cantine', 'Student full name', true),
							'readonly' => true, 
							'div' => 'medium-6 columns', 
							'value' => $this->Form->value('student_id-complete')
						));
						echo $this->Form->input('student_id', array('type' => 'hidden'));				
					} else {
						echo $this->FForm->autocomplete('student_id', array(
							'url' => array('plugin' => 'school', 'controller' => 'students', 'action' => 'autocomplete'),
							'label' => __d('cantine', 'Student full name', true),
							'div' => 'medium-6 columns'
						));
					}
				
				?>
				<?php
					if (empty($this->data['CantineIncidence']['id'])) {
						echo $this->FForm->date('date', array(
							'div' => 'medium-6 columns end',
							'multi' => true, 
							'label' => __d('cantine', 'Date', true),
							'error' => array(
								'uniqueIncidence' => __d('cantine', 'User has a incidence that day', true),
								'weekDay' => __d('cantine', 'Date should be a labour day', true)
								)
							));
					} else {
						echo $this->FForm->date('date', array(
							'div' => 'medium-3 columns end',
							'label' => __d('cantine', 'Date', true),
							'error' => array(
								'uniqueIncidence' => __d('cantine', 'User has a incidence that day', true),
								'weekDay' => __d('cantine', 'Date should be a labour day', true)
								)
							));
					}
				
				?>
			</div>
			<div class="row">
			<?php
				echo $this->FForm->textarea('remark', array(
					'label' => __d('cantine', 'Remarks', true)
				));
			?>
			</div>
		
	</fieldset>
	<?php if ($this->Form->value('CantineIncidence.id')): ?>
		<?php echo $this->element('student_data', array('plugin' => 'cantine')); ?>
	<?php endif ?>
	<?php echo $this->FForm->end(); ?>
	</div>
</section>