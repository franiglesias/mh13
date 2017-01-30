<?php
	$options = array(
		'columns' => array(
			'title' => array('label' => __d('menus', 'Title', true)), 
			'order' => array('label' => __d('menus', 'order', true))
			),
		'actions' => array(
			'edit' => array(
				'label' => __d('menus', 'Move', true),
				'url' => array(
					'action' => 'move'
				),
				'ajax' => array(
					'mh-update' => '#menu-form',
					'mh-indicator' => '#mh-menus-busy-indicator'
				),
			),
			'delete' => array(
				'label' => __('Remove', true), 
				'url' => array(
					'action' => 'nobar'
				),
				'confirm' => __('Are you sure?', true),
				'ajax' => array(
					'mh-update' => '#menus-list',
					'mh-indicator' => '#mh-menus-busy-indicator'
				),
			)
		),
		'table' => array(
			'class' => 'admin-table',
			'ajax' => array(
				'mh-update' => '#menus-list',
				'mh-indicator' => '#mh-menus-busy-indicator',
				'mh-reveal' => '#menu-form'
			)
		)
	);
	
	$theTable = $this->Table->render($menus, $options);
?>

<section id="menus-index" class="mh-ajax-admin-panel">
	<header>
		<h1><?php echo __d('menus', 'Menus in this bar', true); ?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php
			echo $this->XHtml->ajaxLoading('mh-menus-busy-indicator');
			echo $theTable;
			echo $this->Js->writeBuffer();
		?>
	</div>
</section>