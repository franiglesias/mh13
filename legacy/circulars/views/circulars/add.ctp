<section id="circulars-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
			echo $this->Backend->editHeading($this->data, 'Circular', 'circulars', $this->Form->value('Circular.title.spa'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Circular');?> 
		<fieldset>
			<legend><?php __d('circulars', 'Select a Circular Type'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>	
			<?php echo $this->FForm->select('circular_type_id', array(
				'options' => $circularTypes
			)); ?>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>