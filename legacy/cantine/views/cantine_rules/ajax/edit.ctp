<div class="mh-admin-panel">
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
	
	<?php echo $this->Form->create('CantineRule');?> 
		<fieldset>
		<legend><?php __d('cantine', 'CantineRule Definition'); ?></legend>
		<?php if ($this->data) echo $this->Form->input('id'); ?>
		<div class="row">
			<?php
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
		<?php
			echo $this->Form->input('cantine_turn_id',array('type' => 'hidden'));
			
			
		?> 
	</fieldset>
<?php
	// Prepare the submit button
	// This is the action we need to call to update the permissions list
	$url = array(
		'plugin' => 'cantine', 
		'controller' => 'cantine_rules', 
		'action' => 'index', 
		$this->Form->value('CantineRule.cantine_turn_id')
		);

	echo $this->FForm->ajaxSend($url);
?>
	<?php echo $this->Form->end(); ?>
	<?php echo $this->Js->writeBuffer(); ?>
	

</div>
