<section id="technicians-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Technician', 'it', $this->Form->value('Technician.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Technician');?> 
		<fieldset>
			<legend><?php __d('it', 'Technician Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<div class="medium-6 columns">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('it', 'Technician title', true),
					));
					echo $this->FForm->email('email', array(
						'label' => __d('it', 'Contact email', true)
					));
					echo $this->FForm->input('phone', array(
						'label' => __d('it', 'Contact phone', true)
					));
					echo $this->FForm->textarea('remarks', array(
						'label' => __d('it', 'Remarks', true)
					));
				?>
				</div>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>