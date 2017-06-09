<?php
	// $this->FForm->defaults['labelPosition'] = 'inline';
	// $this->FForm->defaults['labelSize'] = 2;
	// $this->FForm->defaults['inputSize'] = 10;
?>
<section id="cantineGroups-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading(
					$this->data, 
					'CantineGroup', 
					'cantine', 
					$this->Form->value('CantineGroup.title')
				);
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CantineGroup');?> 
		<div clas="row">
			<div class="small-4 column">
				<fieldset>
					<legend><?php __d('cantine', 'CantineGroup Definition'); ?></legend>
					<?php if ($this->data) {echo $this->Form->input('id');} ?>	
					<div class="row"><?php
						echo $this->FForm->input('title', array(
							'label' => __d('cantine', 'Group', true),
						));
					?></div>
				</fieldset>
			</div>
			<div class="small-8 column">
				<fieldset>
					<legend><?php __d('cantine', 'Cantine Rules for this group'); ?></legend>
				<?php if (!empty($this->data['CantineRule'])): ?>
					<div class="panel radius clearfix">
						<?php
						$cantineRuleOptions = array(
							'columns' => array(
								'day_of_week' => array(
									'type' => 'days', 
									'mode' => 'labor compact',
									'label' => __d('cantine', 'Day of week', true)
								),
								'cantine_turn_id' => array(
									'label' => __d('cantine', 'Turn', true),
									'type' => 'switch', 
									'switch' => $turns
								),
								'extra1' => array(
									'label' => __d('school', 'Extra1', true),
									'type' => 'switch',
									'switch' => $extraOptions
								),
								'extra2' => array(
									'label' => __d('school', 'Extra2', true),
									'type' => 'switch',
									'switch' => $extraOptions
								),
							)
						);
						echo $this->Table->render($this->data['CantineRule'], $cantineRuleOptions);
					?>
					</div>				
				<?php endif ?>
				</fieldset>
			</div>
		</div>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>