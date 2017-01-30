<section id="subjects-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Subject', 'school', $this->Form->value('Subject.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Subject');?> 
		<fieldset>
			<legend><?php __d('school', 'Subject Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
				echo $this->FForm->input('title', array(
					'label' => __d('school', 'Subject Title', true)
				));
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>