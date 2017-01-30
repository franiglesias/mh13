<section id="circularTypes-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'CircularType', 'circulars', $this->Form->value('CircularType.title'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CircularType');?> 
		<fieldset>
			<legend><?php __d('circulars', 'CircularType Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('circulars', 'Circular Type title', true),
						'div' => 'medium-4 columns'
					));
					echo $this->FForm->input('template', array(
						'label' => __d('circulars', 'Template name', true),
						'div' => 'medium-4 columns end'
					));
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>