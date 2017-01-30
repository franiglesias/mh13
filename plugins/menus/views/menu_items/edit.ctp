<section id="menuItems-edit" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading"><?php 
			if (empty($this->data)) {
				__d('menus', 'Create MenuItem');
			} else {
				__d('menus', 'Modify MenuItem');
			}
			
			?>
		</h1>
		<p class="mh-admin-panel-menu">
		<?php 
			echo $this->Html->link(__('Admin', true), 
				$this->data['App']['returnTo'], 
				array('class' => 'mh-button mh-admin-panel-menu-item mh-button-back')
				);
			if ($this->data) {
			echo $this->Html->link(__('Delete', true),
				array('action' => 'delete', $this->Form->value('MenuItem.id')),
				array(
					'class' => 'mh-button mh-admin-panel-menu-item mh-button-cancel mh-admin-panel-menu-item-alt',
					'confirm' => sprintf(__('Are you sure you want to delete %s?', true), $this->Form->value('MenuItem.label'))
				));
			}
		?>
		</p>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('MenuItem');?>
		<fieldset>
			<legend><?php __d('menus', 'Menu Item'); ?></legend>
		<?php if ($this->data) {echo $this->Form->input('id');} ?>		
		<?php
		echo $this->Form->input('menu_id');
		echo $this->Form->input('label', array('label' => __d('menus', 'Label', true), 'class' => 'input-medium'));
		echo $this->Form->input('url', array('label' => __d('menus', 'Url', true), 'class' => 'input-long'));
		echo $this->Form->input('help', array('label' => __d('menus', 'Help', true), 'class' => 'input-long'));
		echo $this->Form->input('class', array('label' => __d('menus', 'Class', true), 'class' => 'input-long'));
		echo $this->Upload->image('icon', array(
			'after' => __d('menus', '<p>An image for this menu option.</p>', true),
			)
		);
		echo $this->Form->input('order', array('label' => __d('menus', 'Order', true), 'class' => 'input-short'));
		echo $this->Form->input('access', array(
			'label' => __d('menus', 'Access', true),
			'options' => array(
					0 => __d('menus', 'Everyone', true),
					1 => __d('menus', 'Authenticated', true),
					2 => __d('menus', 'With permission to access the url', true),
					)
				)
			);
		?>
		<?php echo $this->Form->input('App.returnTo', array('type' => 'hidden')); ?>
		</fieldset>
		<?php echo $this->Form->end(array('label' => sprintf(__('Submit %s', true), __d('menus', 'MenuItem', true)), 'class' => 'mh-button mh-button-ok'));?>
	</div>
</section>