<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	$this->FForm->defaults['inputSize'] = 10;
?>
<section id="prizes-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				if (empty($this->data['Prize'])) {
					printf(__('Create %s', true), __d('raffles', 'Prize', true));
				} else {
					printf(__('Modify %s \'%s\'', true), __d('raffles', 'Prize', true), $this->Form->value('Prize.title'));
				};
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Prize');?> 
		<fieldset>
			<legend><?php __d('raffles', 'Prize Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
				echo $this->FForm->input('number', array(
					'label' => __d('raffles', 'Number', true),
					'div' => 'medium-3 columns',
					'inputSize' => 3
				));
				echo $this->FForm->input('title', array(
					'label' => __d('raffles', 'Prize', true),
					'div' => 'medium-9 columns'
				));
				
				?>
			</div>
			<div class="row">
			<?php
				echo $this->FForm->input('sponsor', array(
					'label' => __d('raffles', 'Sponsor', true),
					'div' => 'medium-6 columns'
				));
				echo $this->FForm->checkbox('special', array(
					'label' => __d('raffles', 'Special', true),
					'div' => 'medium-2 columns end'
				));
			?>		
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>