<section id="labels-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php echo $this->Page->title('Edit Label'); ?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Label');?> 
		<fieldset>
			<legend><?php __d('labels', 'Label Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<div class="medium-6 columns">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('labels', 'Label title', true),
					));
				?>
				</div>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>