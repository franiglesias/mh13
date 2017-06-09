<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	$this->FForm->defaults['inputSize'] = 3;
?>
<section id="cycles-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Cycle', 'school', $this->Form->value('Cycle.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Cycle');?> 
		<fieldset>
			<legend><?php __d('school', 'Cycle Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
				echo $this->FForm->input('title', array(
					'label' => __d('school', 'Cycle title', true),
					'div' => 'medium-6 columns'
				));
				echo $this->FForm->select('coordinator_id', array(
					'label' => __d('school', 'Coordinated by', true),
					'options' => $coordinators,
					'empty' => __d('school', '-- Select a coordinator --', true),
					'div' => 'medium-4 columns end'
				))
				
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>	
	</div>
</section>