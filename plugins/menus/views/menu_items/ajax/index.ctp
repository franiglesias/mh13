<?php
	$options = array(
		'columns' => array(
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
			'edit' => array(
				'ajax' => array(
					'mh-update' => '#menu-item-form',
					'mh-indicator' => '#mh-menu-items-busy-indicator'
				),
				
			),
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true),
				'ajax' => array(
					'mh-update' => '#menu-items-list',
					'mh-indicator' => '#mh-menu-items-busy-indicator'
				)
			)	
		),
		'table' => array(
			'class' => 'admin-table',
			'ajax' => array(
				'mh-update' => '#menu-items-list',
				'mh-indicator' => '#mh-menu-items-busy-indicator',
				'mh-reveal' => '#menu-item-form'
			)
		)
	);
	$theTable = $this->Table->render($menuItems, $options);
?>
<section id="menuItems-index" class="mh-ajax-admin-panel">
	<header>
		<h1><?php echo __d('menus', 'Items for this menu', true); ?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php
			echo $this->XHtml->ajaxLoading('mh-menu-items-busy-indicator');
			echo $theTable;
			echo $this->Js->writeBuffer();
		?>
	</div>
</section>
