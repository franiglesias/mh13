<?php
$this->FForm->defaults['labelPosition'] = 'inline';
$this->FForm->defaults['labelSize'] = 2;

?>
<section id="permissions-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'Permission', 'access', $this->Form->value('Permission.description'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Permission', array('type' => 'file'));?>
		<fieldset>
			<legend><?php __d('access', 'Permission Definition'); ?></legend>
		<?php if ($this->data) {echo $this->Form->input('id');} ?>
		<div class="row">
			<?php
			echo $this->FForm->input('description', array(
				'div' => 'medium-6 columns',
				'label' => __d('access', 'Description', true),
				'help' => __d('access', 'Brief description of the rule', true)
				)
			);
			?>
		</div>
		<div class="row">
			<?php
			echo $this->FForm->input('url_pattern', array(
				'div' => 'medium-6 columns',
				'label' => __d('access', 'Url pattern', true),
				'help' => __d('access', 'A MySQL pattern that describes a set of url. Use % as placeholder', true)
				)
			);
			?>
		</div>	
		
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>