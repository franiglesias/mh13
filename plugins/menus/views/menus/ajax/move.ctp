<section id="menus-edit" class="mh-admin-panel">
	<header>
		<h1><?php __d('menus', 'Change menu position'); ?></h1>
	</header>
	<?php echo $this->Form->create('Menu');?>
	<fieldset>
		<legend><?php __d('menus', 'Menu'); ?></legend>
	<?php
		echo $this->Form->input('Menu.bar_id', array('type' => 'hidden'));
		echo $this->Form->input('Menu.id', array('type' => 'hidden'));
	 ?>
		<div class="row">
			<?php
				echo $this->FForm->text('title', array(
					'label' => __d('menus', 'The menu', true),
					'div' => 'medium-4 columns',
					'readonly' => true
				));
				echo $this->FForm->input('order', array(
					'label' => __d('menus', 'Order', true),
					'help' => __d('menus', 'Position in the bar', true),
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
	echo $this->Form->end();
	echo $this->Js->writeBuffer(); 
	?>
</section>


