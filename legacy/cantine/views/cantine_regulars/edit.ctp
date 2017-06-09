<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	$this->FForm->defaults['inputSize'] = 10;
?>
<section id="cantineRegulars-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'CantineRegular', 'cantine', $this->Form->value('Student.fullname'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CantineRegular');?> 
			<fieldset>
			<legend><?php __d('cantine', 'CantineRegular Definition'); ?></legend>
			<div class="row">
			<?php
				if (!empty($this->data['CantineRegular']['id'])) {
					echo $this->Form->input('id');
					echo $this->FForm->input('Student.fullname', array(
						'readonly' => true, 
						'div' => 'medium-6 columns', 
						'inputSize' => 6,
						'value' => $this->Form->value('student_id-complete'),
						'label' => __d('cantine', 'Student full name', true)
						)
					);
					echo $this->Form->input('student_id', array('type' => 'hidden'));
				} else {
					echo $this->FForm->autocomplete('student_id', array(
						'url' => array('plugin' => 'school', 'controller' => 'students', 'action' => 'autocomplete'),
						'div' => 'medium-6 columns',
						'label' => __d('cantine', 'Student full name', true),
						'valueLabel' => '',
						'error' => array(
							'validStudent' => __d('cantine', 'Invalid student or bad selection in list', true),
							'emptyStudent' => __d('cantine', 'Select a valid student name', true)
						)
					));
				}
			?>
			</div>
			<div class="row">
			<?php
			if (empty($this->data['CantineRegular']['id'])) {
				echo $this->FForm->checkboxes('month', array(
					'options' => $months, 
					'label' => __d('cantine', 'Months', true),
					'div' => 'medium-5 columns',
					'checkall' => true,
					'error' => array(
						'emptyMonth' => __d('cantine', 'Please, check at least a month', true),
						'uniqueRegular' => __d('cantine', 'This student is registered for this same month', true),
						)
					)
				);
			} else {
				echo $this->FForm->select('month', array(
					'options' => $months,
					'div' => 'medium-3 columns',
					'inputSize' => 2,
					'label' => __d('cantine', 'Month', true),
					'error' => array(
						'uniqueRegular' => __d('cantine', 'This student is registered for this same month', true),
						)
					
					)
				);
			}
			echo $this->FForm->days('days_of_week', array(
				'format' => 'labor',
				'label' => __d('cantine', 'Days of week', true),
				'div' => 'medium-6 columns end'
			));
			?>					
			</div>
	
		</fieldset>
		<?php
			echo $this->Form->input('App.returnTo', array('readonly' => true, 'type' => 'hidden', 'class' => 'input-long'));
		?>
		<?php if ($this->Form->value('CantineRegular.id')): ?>
			<?php echo $this->element('student_data', array('plugin' => 'cantine')); ?>
		<?php endif ?>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>