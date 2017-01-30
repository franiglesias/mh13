<?php $this->Maintenance->bind($this->data); ?>
<section id="maintenance-form" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Maintenance', 'it', $this->Form->value('Maintenance.id'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Maintenance');?> 
		
			<fieldset>
			<legend><?php __d('it', 'Maintenance Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>	
			<?php
				echo $this->FForm->hidden(array(
					'device_id'
				));
			?>
			<div class="row">
				<?php
					echo $this->FForm->date('Maintenance.requested', array(
						'label' => __d('it', 'Requested', true),
						'multi' => false,
						'readonly' => true,
						'clearable' => true,
						'div' => 'medium-3 columns'
					));
					echo $this->FForm->textarea('description', array(
						'label' => __d('it', 'Description', true),
						'rows' => 3,
						'div' => 'medium-6 columns'
					));
					echo $this->FForm->date('Maintenance.detected', array(
						'label' => __d('it', 'Detected', true),
						'multi' => false,
						'readonly' => true,
						'clearable' => true,
						'div' => 'medium-3 columns'
					));
				?>
			</div>
			<div class="row">
				<?php
					echo $this->FForm->select('technician_id', array(
						'label' => __d('it', 'Assigned to', true),
						'options' => $technicians,
						'div' => 'medium-3 columns'
				
					));
					echo $this->FForm->select('maintenance_type_id', array(
						'label' => __d('it', 'Maintenance Type', true),
						'div' => 'medium-3 columns',
						'options' => $maintenanceTypes
					));
					echo $this->FForm->textarea('action', array(
						'label' => __d('it', 'Action', true),
						'rows' => 3,
						'div' => 'medium-6 columns'
					));
				?>
			</div>
			<div class="row">
				<?php
					echo $this->FForm->select('status', array(
						'label' => __d('it', 'Status', true),
						'options' => $this->Maintenance->statuses,
						'readonly' => true,
						'div' => 'medium-3 columns'
					));
					echo $this->Maintenance->transitions('medium-6 columns');
					echo $this->FForm->date('resolved', array(
						'label' => __d('it', 'Resolution date', true),
						'multi' => false,
						'clearable' => true,
						'readonly' => true,
						'div' => 'medium-3 columns'
					));
				
				?>
			</div>
			<div class="row">
				<?php
					echo $this->FForm->textarea('remarks', array(
						'label' => __d('it', 'Remarks', true),
						'rows' => 3,
					));
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>