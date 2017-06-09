<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 4;
	$this->FForm->defaults['inputSize'] = 8;
?>
<section id="sections-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'Section', 'school', $this->Form->value('Section.title'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<div class="row">
			<div class="small-6 columns">
				<?php echo $this->Form->create('Section');?> 
				<fieldset>
					<legend><?php __d('school', 'Section Definition'); ?></legend>
					<?php if (!empty($this->data['Section'])) echo $this->Form->input('id'); ?>	
					<div class="row">
						<?php
							echo $this->FForm->input('title', array(
								'label' => __d('school', 'Section title', true),
								'div' => 'medium-4 columns',
								'inputSize' => 8
							));
							echo $this->FForm->select('tutor_id', array(
								'label' => __d('school', 'Tutorized by', true),
								'options' => $tutors,
								'empty' => __d('school', '-- Select a tutor --', true),
								'div' => 'medium-4 columns end'
							))
						?>
					</div>

					<div class="row">
						<?php
						echo $this->FForm->select('level_id', array(
							'options' => $levels,
							'label' => __d('school', 'Level', true),
							'div' => 'medium-2 columns'
							)
						);
						echo $this->FForm->select('cycle_id', array(
							'options' => $cycles,
							'label' => __d('school', 'Cycle', true),
							'div' => 'medium-2 columns'
							)
						);
						echo $this->FForm->select('stage_id', array(
							'options' => $stages,
							'label' => __d('school', 'Stage', true),
							'div' => 'medium-4 columns end'
							)
						);
						?>
					</div>
					<div class="row">
					<?php
						echo $this->FForm->select('cantine_group_id', array(
							'options' => $cantineGroups,
							'label' => __d('cantine', 'Cantine Group', true),
							'div' => 'medium-5 columns end'
							)
						);
					?>		
					</div>
				</fieldset>
				<?php echo $this->FForm->end(); ?>
			</div>
			<div class="small-6 columns">
				<?php 
					$this->Students->bind($students);
					echo $this->Students ->overviewTable(); 
				?>
			</div>
			
		</div>
	</div>
</section>