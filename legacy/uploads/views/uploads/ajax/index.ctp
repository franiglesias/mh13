<?php
	$options = array(
		'columns' => array(
			'path' => array(
				'type' => 'preview', 
				'label' => __d('uploads', 'Preview', true), 
				'attr' => array('class' => 'cell-stretch')
			),
			'name' => array(
				'attr' => array('class' => 'cell-long'), 
				'label' => __d('uploads', 'Name', true)
			),
			'description' => array(
				'label' => __d('uploads', 'Description', true)
			),
			'order' => array(
				'label' => __d('uploads', 'Order', true)
			),
			'size' => array(
				'type' => 'size',
				'attr' => array('class' => 'cell-number cell-medium'),
				'label' => __d('uploads', 'Size', true)
			), 
			'exists' => array(
				'type' => 'boolean',
				'attr' => array('class' => 'cell-short'),
				'label' => __d('uploads', 'Exists', true)
			),
		),
		'actions' => array(
			'edit' => array(
				'label' => __('Edit', true),
				'ajax' => array(
					'mh-update' => '#upload-form',
					'mh-indicator' => '#mh-uploads-busy-indicator'
				)
			),
			'download' => array(
				'label' => __d('uploads', 'Download', true),
				'url' => array(
					'admin' => false,
					'action' => 'download'
				)
			),
			'delete' => array( 
				'label' => __('Delete', true),
				'confirm' => __('Are you sure?', true),
				'ajax' => array(
					'mh-update' => '#uploads-list',
					'mh-indicator' => '#mh-uploads-busy-indicator'
				)
			)
		),
		'table' => array(
			'class' => 'admin-table',
			'ajax' => array(
				'mh-update' => '#uploads-list',
				'mh-indicator' => '#mh-uploads-busy-indicator',
				'mh-reveal' => '#upload-form'
			)
		)
	);
	$theTable = $this->Table->render($uploads, $options);
?>
<section id="uploads-index" class="mh-ajax-admin-panel">
	<header>
		<h1><?php echo __d('uploads', 'Uploads for this Item', true); ?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php
			echo $this->XHtml->ajaxLoading('mh-uploads-busy-indicator');
			echo $theTable;
			echo $this->Js->writeBuffer();
		?>
	</div>
</section>