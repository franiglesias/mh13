<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	$this->FForm->defaults['inputSize'] = 3;
?>
<section id="stages-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Stage', 'school', $this->Form->value('Stage.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Stage');?> 
		<fieldset>
			<legend><?php __d('school', 'Stage Definition'); ?></legend>
			<div class="row">
				<?php
				echo $this->FForm->input('title', array(
					'label' => __d('school', 'Stage Title', true),
					'div' => 'medium-6 columns'
				));
				echo $this->FForm->input('abbr', array(
					'label' => __d('school', 'Abbr', true),
					'div' => 'medium-2 columns',
					'inputSize' => 1,
				));
				echo $this->FForm->select('coordinator_id', array(
					'label' => __d('school', 'Coordinated by', true),
					'options' => $coordinators,
					'empty' => __d('school', '-- Select a coordinator --', true),
					'div' => 'medium-4 columns'
				))
				?>
			</div>
			<?php if ($this->data) echo $this->Form->input('id'); ?>	
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>