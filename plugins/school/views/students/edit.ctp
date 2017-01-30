<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	$this->FForm->defaults['inputSize'] = 6;
?>
<section id="students-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'Student', 'school', $this->Form->value('Student.name'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Student');?> 
			<fieldset>
			<legend><?php __d('school', 'Student Definition'); ?></legend>
			<?php if (!empty($this->data['Student'])) echo $this->Form->input('id'); ?>	
			<div class="row">
				<?php
				echo $this->FForm->input('firstname', array(
					'label' => __d('school', 'First Name', true),
					'div' => 'medium-4 columns'
				));
				echo $this->FForm->input('lastname1', array(
					'label' => __d('school', 'Last Name 1', true),
					'div' => 'medium-4 columns'
				));
				echo $this->FForm->input('lastname2', array(
					'label' => __d('school', 'Last Name 2', true),
					'div' => 'medium-4 columns'
				));
				?>
			</div>
			<div class="row">
				<?php
				echo $this->FForm->select('section_id', array(
					'label' => __d('school', 'Section title', true),
					'options' => $sections,
					'div' => 'medium-3 columns',
					'inputSize' => 3
				));
				echo $this->FForm->days('extra1', array(
					'label' => __d('school', 'Extra1', true), 
					'format' => 'labor',
					'div' => 'medium-6 columns'
				));
				echo $this->FForm->checkbox('extra2', array(
					'label' => __d('school', 'Extra2', true),
					'div' => 'medium-2 columns'
				));
				?>
			</div>
			<div class="row">
				<?php
				echo $this->FForm->textarea('remarks', array(
					'label' => __d('school', 'Remarks', true)
				));
				?>
			</div>
					
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>