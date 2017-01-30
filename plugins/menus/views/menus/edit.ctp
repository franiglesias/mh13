<section id="menus-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php echo $this->Backend->editHeading($this->data, 'Menu', 'menus', $this->Form->value('Menu.title')); ?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Menu');?>
		<fieldset>
			<legend><?php __d('menus', 'Menu'); ?></legend>
		<?php if (!empty($this->data['Menu'])) {echo $this->Form->input('id');} ?>
		<div class="row">
			<div class="medium-7 column">
				<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('menus', 'Title', true),
						'help' => __d('menus', 'A name for this menu', true),
						'div' => 'medium-6 columns'
					));
					echo $this->FForm->input('label', array(
						'label' => __d('menus', 'Label', true),
						'help' => __d('menus', 'Visible label for menu', true),
						'div' => 'medium-6 columns'
					));
				?>
					
				</div>
				<div class="row">
					<?php
					echo $this->FForm->input('help', array(
						'label' => __d('menus', 'Help', true), 
						'class' => 'input-long',
						'help' => __d('menus','A help text for this menu', true)
					));
					?>
				</div>
				
				
			</div>
			<div class="medium-5 column">
				<?php
					echo $this->FForm->icons('icon', array(
						'label' => __d('menus', 'Icon', true),
						'help' => __d('menus', 'An icon for this menu.', true),
					));
				
				?>
			</div>
		</div>
		<div class="row">
			<?php
			echo $this->FForm->select('bar_id', array(
				'label' => __d('menus', 'Menu Bar', true),
				'help' => __d('menus', 'A menu bar to associate this menu', true),
				'options' => $bars,
				'empty' => __d('menus', 'No menu bar', true),
				'div' => 'medium-3 columns'
			));
			echo $this->FForm->input('order', array(
				'label' => __d('menus', 'Order', true),
				'help' => __d('menus', 'Position in the bar', true),
				'div' => 'medium-2 columns end'
			));
			
			?>
		</div>
		<div class="row">
			<?php
			echo $this->FForm->input('url', array(
				'label' => __d('menus', 'Url or access token', true),
				'help' => __d('menus', 'Url or access token', true),
				'div' => 'medium-6 columns'
			));
			echo $this->FForm->select('access', array(
				'div' => 'medium-6 columns end',
				'label' => __d('menus', 'Access', true),
				'options' => array(
						0 => __d('menus', 'Everyone', true),
						1 => __d('menus', 'Authenticated', true),
						2 => __d('menus', 'With permission to access the url', true),
					),
				'help' => __d('menus', 'Who has permission to see and access this item?', true)
			));
			?>
		</div>
		
		<?php if ($this->Form->value('Menu.id')): ?>
		<div class="panel radius clearfix">
			<div id="menu-items-list">
				<?php
					$items = $this->requestAction(
						array('plugin' => 'menus', 'controller' => 'menu_items', 'action' => 'index'),
						array('return', 'pass' => array(0 => $this->Form->value('Menu.id')))
					);
					echo $items;
				?>
			</div>
			<?php 
				$addUrl = Router::url(array(
					'plugin' => 'menus', 
					'controller' => 'menu_items', 
					'action' => 'add', 
					$this->Form->value('Menu.id')
					), 
					true
				);
				echo $this->FForm->ajaxAdd($addUrl, array(
					'childModel' => 'MenuItem', 
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
<div id="menu-item-form" class="reveal-modal" data-reveal></div>
