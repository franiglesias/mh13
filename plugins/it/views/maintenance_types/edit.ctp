<section id="maintenanceTypes-edit" class="mh-admin-panel">
	<header>
		<h1><?php
				echo $this->Backend->editHeading($this->data, 'MaintenanceType', 'it', $this->Form->value('MaintenanceType.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('MaintenanceType');?> 
			<fieldset>
			<legend><?php __d('it', 'MaintenanceType Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('it', 'Maintenance Type', true),
						'div' => 'medium-6 columns end'
					));
				?> 
				
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>