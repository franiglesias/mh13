<section id="planet-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'Planet', 'aggregator', $this->Form->value('Planet.title'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Planet', array('type' => 'file'));?>
		<fieldset>
			<legend><?php __d('aggregator', 'Planet data'); ?></legend>
			<?php if ($this->data) {echo $this->Form->input('id');} ?>
			<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('aggregator', 'Title', true), 
						'div' => 'medium-4 columns'
					));
					echo $this->FForm->checkbox('private', array(
						'label' => __d('aggregator', 'Private', true), 
						'help' => __d('aggregator', 'General public can\'t add feeds to Private Planets.', true),
						'div' => 'medium-2 columns end'
					));
				?>
			</div>
			<div class="row">
				<?php
					echo $this->FForm->textarea('description', array(
						'label' => __d('aggregator', 'Description', true), 
						'div' => 'medium-6 columns'
					));
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
