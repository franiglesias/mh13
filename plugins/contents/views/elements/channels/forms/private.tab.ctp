<fieldset>
	<legend><?php __d('contents', 'Private Channel') ?></legend>
	<div class="row">
		<?php
		echo $this->FForm->help(
			null,
			__d('contents', 'You can restrict access to this channel.', true),
			__d('contents', 'Check on the private switch and select the roles that can access to the contents on this channel.', true),
			__d('contents', 'Check off the private switch to make this channel open to all visitors.', true)
		);
		?>
	</div>
	<div class="row">
		<?php
		echo $this->FForm->checkbox('private', array(
			'label' => __d('contents', 'Private', true),
			'div' => 'medium-2 columns',
			'help' => __d('contents', 'Make this channel private for roles', true)
		));
		echo $this->FForm->select('Role', array(
			'label' => __d('access', 'Role', true),
			'options' => $roles,
			'multiple' => 'checkbox',
			'help' => __d('contents', 'Roles that can access this channel.', true),
			'div' => 'medium-10 columns',
			));						
		?>
	</div>
</fieldset>
