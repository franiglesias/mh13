<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	$this->FForm->defaults['inputSize'] = 10;
?>

<section id="cantineTickets-edit" class="mh-admin-panel">
	<header>
		<h1>
		<?php echo $this->Backend->editHeading(
			$this->data, 
			'CantineTicket', 
			'cantine', 
			$this->Form->value('Student.fullname')
			);
		?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CantineTicket');?> 
			<fieldset>
			<legend><?php __d('cantine', 'CantineTicket Definition'); ?></legend>
			<div class="row">
				<?php
					if (!empty($this->data['CantineTicket']['id'])) {
						echo $this->Form->input('id');
						echo $this->FForm->input('Student.fullname', array(
							'readonly' => true, 
							'div' => 'medium-6 columns', 
							'inputSize' => 6,
							'value' => $this->Form->value('student_id-complete'),
							'label' => __d('cantine', 'Student full name', true)
							));
						echo $this->Form->input('student_id', array('type' => 'hidden'));
					} else {
						echo $this->FForm->autocomplete('student_id', array(
							'url' => array('plugin' => 'school', 'controller' => 'students', 'action' => 'autocomplete'),
							'div' => 'medium-6 columns',
							'label' => __d('cantine', 'Student full name', true),
							'error' => array(
								'validStudent' => __d('cantine', 'Invalid student or bad selection in list', true),
								'emptyStudent' => __d('cantine', 'Select a valid student name', true)
							)
					
						));
					}
					if (empty($this->data['CantineTicket']['id'])) {
						echo $this->FForm->date('date', array(
							'label' => __d('cantine', 'Date', true),
							'multi' => true, 
							'clearable' => true,
							'inputSize' => 3,
							'prefixSize' => 1,
							'postfixSize' => 1,
							'div' => 'medium-6 columns end',
							'error' => array(
								'uniqueTicket' => __d('cantine', 'User has a ticket that day', true),
								'weekDay' => __d('cantine', 'Date should be a labour day', true)
								)
							));
					} else {
						echo $this->FForm->date('date', array(
							'label' => __d('cantine', 'Date', true),
							'clearable' => true,
							'inputSize' => 2,
							'prefixSize' => 1,
							'postfixSize' => 1,
							
							'div' => 'medium-3 columns end',
							'error' => array(
								'uniqueTicket' => __d('cantine', 'User has a ticket that day', true),
								'weekDay' => __d('cantine', 'Date should be a labour day', true)
								)
							));
					}
				
				?>
			</div>
			<?php
			?>		
		
		</fieldset>
		<?php if ($this->Form->value('CantineTicket.id')): ?>
			<?php echo $this->element('student_data', array('plugin' => 'cantine')); ?>
		<?php endif ?>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>