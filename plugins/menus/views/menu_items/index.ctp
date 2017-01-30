<section id="menuItems-index" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading"><?php __d('menus', 'Admin Menu Items');?></h1>
		<p class="mh-admin-panel-menu">
		<?php echo $this->Html->link(__('Add', true), array('action' => 'add'), array('class' => 'mh-button mh-admin-panel-menu-item mh-button-ok mh-button-add')) ?>
		</p>
		<?php echo $this->element('paginators/mh-mini-paginator'); ?>
	</header>
	<?php
		echo $this->SimpleFilter->form();
		echo $this->SimpleFilter->options('MenuItem.menu_id', array('label' => __d('menus', 'Menu', true),'options' => $filterMenuOptions));
		echo $this->SimpleFilter->options('MenuItem.access', array('label' => __d('menus', 'Access', true), 'options' => $filterAccessOptions));
		echo $this->SimpleFilter->end();
	?>
	
	<div class="mh-admin-panel-body">
		<?php
		$options = array(
			'columns' => array(
				'Menu.title' => array('label' => __d('menus', 'Menu', true), 'attr' => array('class' => 'cell-medium')),
				'label'=> array('label' => __d('menus', 'Label', true), 'attr' => array('class' => 'cell-long')), 
				'url'=> array('label' => __d('menus', 'Url', true)), 
				'order'=> array('label' => __d('menus', 'Order', true), 'attr' => array('class' => 'cell-short')), 
				'access' => array(
					'label' => __d('menus', 'Access', true),
					'type' => 'switch',
					'attr' => array('class' => 'cell-long'),
					'switch' => $filterAccessOptions
					),
				),
			'actions' => array(
				'edit' => array('label' => __('Edit', true)),
				'delete' => array(
					'label' => __('Delete', true), 
					'confirm' => __('Are you sure?', true)
	 				)
				),
			'table' => array(
				'class' => 'admin-table'
			)
	
			);
		
		echo $this->Table->render($menuItems, $options);
		
		?>	
	</div>
</section>