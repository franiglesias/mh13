<section id="menus-edit" class="mh-admin-panel">
	<header>
		<h1><?php __d('menus', 'Add a menu to current bar'); ?></h1>
	</header>
	<?php echo $this->Form->create('Menu');?>
	<fieldset>
		<legend><?php __d('menus', 'Menu'); ?></legend>
	<?php echo $this->Form->input('Menu.bar_id', array('type' => 'hidden')); ?>
		<div class="row">
			<?php
				echo $this->FForm->select('id', array(
					'label' => __d('menus', 'Select a menu', true),
					'div' => 'medium-4 columns',
					'options' => $menus,
					'empty' => false,
					'help' => __d('menus', 'Select a menu to include in this bar', true)
				));
				echo $this->FForm->input('order', array(
					'label' => __d('menus', 'Order', true),
					'help' => __d('menus', 'Position in the bar, last by default.', true),
					'div' => 'medium-2 columns end'
				));
				
			?>
		</div>
	</fieldset>
	<?php
	// Prepare the submit button
	// This is the action we need to call to update the menu items list
	$url = array('plugin' => 'menus', 'controller' => 'menus', 'action' => 'index', $this->Form->value('Menu.bar_id'));
	echo $this->FForm->ajaxSend($url);
	?>
	<?php echo $this->Form->end(); ?>
	<?php echo $this->Js->writeBuffer(); ?>
</section>


