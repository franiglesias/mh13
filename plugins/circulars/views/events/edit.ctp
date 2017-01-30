<?php
$this->FForm->defaults['labelPosition'] = 'inline';
$this->FForm->defaults['labelSize'] = 3;

?>
<section id="events-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php echo $this->Backend->editHeading($this->data, 'Event', 'circulars', $this->Form->value('Event.title'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Event');?> 
			<fieldset>
				<legend><?php __d('circulars', 'Event Definition'); ?></legend>
				<?php if ($this->data) echo $this->Form->input('id'); ?>
				<div class="row">
					<div class="medium-9 columns">
						<?php
							echo $this->FForm->input('title', array(
								'label' => __d('circulars', 'Event title', true)
							));
							echo $this->FForm->textarea('description', array(
								'label' => __d('circulars', 'Event description', true)
							));
							echo $this->FForm->input('place', array(
								'label' => __d('circulars', 'Place', true)
							));
						?>
					</div>
					<div class="medium-3 columns">
							<?php
								echo $this->FForm->checkbox('publish', array(
									'label' => __d('circulars', 'Publish', true),
									'labelSize' => 4,
									'labelPosition' => 'top'
								));
							?>
					</div>
				</div>
				<div class="row">
					<div class="medium-9 columns">
						<?php
							echo $this->FForm->date('startDate', array(
								'label' => __d('circulars', 'Start Date', true),
								'div' => 'medium-6 columns',
								'inputSize' => 3
							));
							echo $this->FForm->time('startTime', array(
								'label' => __d('circulars', 'Start Time', true),
								'interval' => 5,
								'timeFormat' => 24,
								'empty' => true,
								'inputSize' => 3,
								'div' => 'medium-4 columns end'
							));
							echo $this->FForm->date('endDate', array(
								'label' => __d('circulars', 'End Date', true),
								'div' => 'medium-6 columns',
								'inputSize' => 3
							));
							echo $this->FForm->time('endTime', array(
								'label' => __d('circulars', 'End Time', true),
								'interval' => 5,
								'timeFormat' => 24,
								'empty' => true,
								'inputSize' => 3,
								'div' => 'medium-4 columns end'
							));
						?>
					</div>
					<div class="medium-3 columns">
						<?php
							echo $this->FForm->checkbox('continuous', array(
								'label' => __d('circulars', 'Continuous', true),
								'labelSize' => 4,
								'labelPosition' => 'top'
							));
						?>
					</div>
				</div>
			</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>