<?php
$this->FForm->defaults['labelPosition'] = 'inline';
$this->FForm->defaults['labelSize'] = 2;

?>
<section id="roles-edit" class="mh-admin-panel">
	<header>
		<h1><?php echo $this->Backend->editHeading(
					$this->data, 
					'Role', 
					'access', 
					$this->Form->value('Role.role')
					);
			?></h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Role'); ?>
		<fieldset>
			<legend><?php __d('access', 'Role data'); ?></legend>
			<?php if ($this->data) {echo $this->Form->input('id');} ?>
			<div class="row">
				<?php
				echo $this->FForm->input('role', array(
					'div' => 'medium-6 columns',
					'label' => __d('access', 'Role', true),
					'help' => __d('access', 'Name for role',true),
					'placeholder' => __d('access', 'User', true)
					));
				?>
			</div>	
			<div class="row">
				<?php
				echo $this->FForm->input('description', array(
					'div' => 'medium-6 columns',
					'label' => __d('access', 'Description', true),
					'help' => __d('access', 'Verbose description of the role capabilities',true),
					'placeholder' => __d('access', 'This role allows access to some part', true)
					));
				
				?>
			</div>
			<?php if ($this->Form->value('Role.id')): ?>
			<div class="panel radius clearfix">
				<div id="permissions-list">
					<?php
						$permissions = $this->requestAction(
							array('plugin' => 'access', 'controller' => 'permissions_roles', 'action' => 'index'),
							array('return', 'pass' => array(0 => $this->Form->value('Role.id')))
						);
						echo $permissions;
					?>
				</div>
				<?php 
					$addUrl = Router::url(array(
						'plugin' => 'access', 
						'controller' => 'permissions_roles', 
						'action' => 'add', 
						$this->Form->value('Role.id')
						), 
						true
					);
					echo $this->FForm->ajaxAdd($addUrl, array(
						'childModel' => 'PermissionsRole', 
						'class' => 'mh-btn-child-ok'
					)); 
				?>

			</div>
			<?php endif ?>
		
		
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
<!-- Modal -->
<div id="permissions-role-form" class="reveal-modal ui-front" data-reveal></div>