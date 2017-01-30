<section id="deviceTypes-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'DeviceType', 'it', $this->Form->value('DeviceType.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('DeviceType');?> 
		<fieldset>
			<legend><?php __d('it', 'DeviceType Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('it', 'Device Type', true),
						'div' => 'medium-5 columns'
					));
					echo $this->FForm->input('abbr', array(
						'label' => __d('it', 'Abbreviation', true),
						'div' => 'medium-2 columns end'
					));
				?> 
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>