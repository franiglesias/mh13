<div class="mh-admin-panel">
	<header>
		<h1><?php __d('access', 'Edit Permissions for Role');?></h1>
	</header>
	
	<?php
		echo $this->Form->create('PermissionsRole', array('class' => 'ui-front')); 
	?>
	
	<fieldset>
		<legend><?php __d('access', 'Permission Definition'); ?></legend>
		<?php if ($this->data) {echo $this->Form->input('id');} ?>
		
	<div class="row">
		<?php
		echo $this->FForm->autocomplete('permission_id', array(
			'div' => 'medium-6 columns',
			'label' => __d('access', 'Permission', true),
			'url' => array('plugin' => 'access', 'controller' => 'permissions', 'action' => 'autocomplete'),
			'help' => __d('access', 'A MySQL pattern that describes a set of url. Use % as placeholder', true)
			)
		);
		echo $this->FForm->input('access', array(
			'div' => 'medium-2 columns',
			'label' => __d('access', 'Access', true),
			'options' => array(0 => 'Deny', 1 => 'Allow'), 
			'help' => __d('access', 'Allow or Deny these urls to the role', true)
			)
		);
		?>
	</div>
	<?php
		echo $this->Form->input('role_id', array(
			'type' => 'hidden',
			)
		);
	?>
	</fieldset>
	<?php
	// Prepare the submit button
	// This is the action we need to call to update the permissions list
	$url = array(
		'plugin' => 'access', 
		'controller' => 'permissions_roles', 
		'action' => 'index', 
		$this->Form->value('PermissionsRole.role_id')
		);
		
	echo $this->FForm->ajaxSend($url);
	echo $this->Form->end();
	echo $this->Js->writeBuffer();
	?>
</div>
