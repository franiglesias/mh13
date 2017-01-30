<?php
	$options = array(
		'columns' => array(
			'id', 
			'title', 
		),
		'actions' => array(
			'edit' => array(
				'label' => __('Edit', true),
				'ajax' => array(
					'mh-update' => '#label-form',
					'mh-indicator' => '#mh-labels-busy-indicator',
				),
			),
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true),
				'ajax' => array(
					'mh-update' => '#labels-list',
					'mh-indicator' => '#mh-labels-busy-indicator',
				)
			)
		),
		'table' => array(
			'class' => 'admin-table',
			'ajax' => array(
				'mh-update' => '#labels-list',
				'mh-indicator' => '#mh-labels-busy-indicator',
				'mh-reveal' => '#label-form'
				)
			
		)
	);
	
	$theTable = $this->Table->render($labels, $options);
?>
<section id="labels-index" class="mh-ajax-admin-panel">
	<header>
		<h1><?php echo __d('labels', 'Labels for this Channel', true); ?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php
			echo $this->XHtml->ajaxLoading('mh-labels-busy-indicator');
			echo $theTable;
			echo $this->Js->writeBuffer();
		?>
	</div>
</section>