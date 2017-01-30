<section id="cantineRules-edit" class="mh-admin-panel">
	<header>
		<h1><?php 
			echo $this->Backend->editHeading(
				$this->data, 
				'CantineRule', 
				'cantine', 
				$this->Form->value('CantineRule.section_id')
			);
			?>
		</h1>
	</header>

	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CantineRule');?> 
			<fieldset>
			<legend><?php __d('cantine', 'CantineRule Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
					echo $this->FForm->select('cantine_turn_id', array(
						'tabindex' => 2,
						'options' => $cantineTurns,
						'div' => 'medium-4 columns',
						'label' => __d('cantine', 'Cantine Turn', true),
						'help' => __d('cantine', 'The turn to apply this rule', true)
					));
					echo $this->FForm->days('day_of_week', array(
						'label' => __d('cantine', 'Days of week', true),
						'help' => __d('cantine', 'Check all days of week for this rule to apply', true),
						'format' => 'labor', 
						'tabindex' => 1,
						'div' => 'medium-8 columns end'
					));
				?>
			</div>
			<div class="row">
				<?php
					echo $this->FForm->select('cantine_group_id', array(
						'tabindex' => 2,
						'options' => $cantineGroups,
						'div' => 'medium-4 columns',
						'label' => __d('cantine', 'Cantine group', true),
						'help' => __d('cantine', 'The group to apply this rule', true)
					));
					echo $this->FForm->select('extra1', array(
						'options' => $states, 
						'tabindex' => 3,
						'div' => 'medium-2 columns',
						'label' => __d('cantine', 'extra1', true),
						'help' => __d('cantine', 'Apply to students with extra classes?', true)

					));
					echo $this->FForm->select('extra2', array(
						'options' => $states, 
						'tabindex' => 3,
						'div' => 'medium-2 columns end',
						'label' => __d('cantine', 'extra2', true),
						'help' => __d('cantine', 'Apply to students with Alcor?', true)
					));

				?>
			</div>
				
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
