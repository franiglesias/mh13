<div class="mh-admin-panel" id="test">
	<header>
		<h1><?php 
			echo $this->Backend->editHeading($this->data, 'MenuItem', 'menus', $this->Form->value('MenuItem.label'));
			?>
		</h1>
	</header>
	
	<?php
		$f = $this->Form->create('MenuItem'); 
		echo $f;
	?>
	
	<fieldset>
		<legend><?php __d('menus', 'Menu Item'); ?></legend>

		<?php if ($this->data) {echo $this->Form->input('id');} ?>
		<?php echo $this->Form->input('menu_id', array('type' => 'hidden')); ?>
		
		<div class="row">
			<?php
				echo $this->FForm->input('label', array(
					'label' => __d('menus', 'Label', true), 
					'div' => 'medium-4 columns',
					'help' => __d('menus', 'A label for this menu item', true)
				));
				echo $this->FForm->input('url', array(
					'label' => __d('menus', 'Url', true), 
					'div' => 'medium-8 columns',
					'help' => __d('menus', 'The url for this menu item', true)
				));
			?>
		</div>
		<div class="row">
			<?php
				echo $this->FForm->input('order', array(
					'label' => __d('menus', 'Order', true), 
					'div' => 'medium-2 columns',
					'help' => __d('menus', 'Order position in the menu', true)
				));
				echo $this->FForm->select('access', array(
					'div' => 'medium-6 columns',
					'label' => __d('menus', 'Access', true),
					'options' => array(
						0 => __d('menus', 'Everyone', true),
						1 => __d('menus', 'Authenticated', true),
						2 => __d('menus', 'With permission to access the url', true),
					),
					'help' => __d('menus', 'Who has permission to see and access this item?', true)
				));
				echo $this->FForm->icons('icon', array(
					'label' => __d('menus', 'Icon', true),
					'help' => __d('menus', 'An image for this menu option', true),
					'div' => 'medium-4 columns'
					)
				);
			?>
		</div>
		<div class="row">
			<?php
				echo $this->FForm->textarea('help', array(
					'label' => __d('menus', 'Help', true), 
					'div' => 'medium-6 columns'
				));
				
			?>
		</div>
	</fieldset>

<?php
	$url = array('plugin' => 'menus', 'controller' => 'menu_items', 'action' => 'index', $this->Form->value('MenuItem.menu_id'));
	
	echo $this->FForm->ajaxSend($url);
	echo $this->Form->end();
	echo $this->Js->writeBuffer();
?>
</div>
