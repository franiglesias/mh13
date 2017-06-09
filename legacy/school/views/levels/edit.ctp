<?php
$this->FForm->defaults['labelPosition'] = 'inline';
$this->FForm->defaults['labelSize'] = 2;
?>
<section id="levels-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Level', 'school', $this->Form->value('Level.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Level');?> 
		<fieldset>
			<legend><?php __d('school', 'Level Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
				echo $this->FForm->input('title', array(
					'label' => __d('school', 'Level title', true),
					'inputSize' => 5,
					'div' => 'medium-6 columns'
				));	
				echo $this->FForm->checkbox('private', array(
					'label' => __d('school', 'Private', true),
					'div' => 'medium-3 columns'
				));
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>