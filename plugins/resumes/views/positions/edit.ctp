<section id="positions-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Position', 'resumes', $this->Form->value('Position.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Position');?> 
			<fieldset>
			<legend><?php __d('resumes', 'Position Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
			<?php
				echo $this->FForm->input('title', array(
					'label' => __d('resumes', 'Position', true),
					'div' => 'medium-6 columns end'
				));
			?>
			</div>
			<div class="row">
			<?php
				echo $this->FForm->textarea('description', array(
					'label' => __d('resumes', 'Description', true),
					'div' => 'medium-6 columns end'
				));
			?> 
			</div>
			</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>