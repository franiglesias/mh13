<section id="circularBoxes-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'CircularBox', 'circulars', $this->Form->value('CircularBox.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CircularBox');?> 
		<fieldset>
			<legend><?php __d('circulars', 'CircularBox Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('circulars', 'Circular Box title', true),
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