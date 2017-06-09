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
			'description' => array('display' => false, 'label' => __d('uploads', 'Description', true)),
			'type' => array('display' => false, 'attr' => array('class' => 'cell-medium'), 'label' => __d('uploads', 'Type', true)), 
			'size' => array(
				'type' => 'size',
				'attr' => array('class' => 'cell-number cell-medium'),
				'label' => __d('uploads', 'Size', true)
				), 
			'exists' => array(
				'type' => 'boolean',
				'label' => __d('uploads', 'Exists', true)
				)
			),
		'actions' => array(
			'edit' => array('label' => __('Edit', true)),
			'download' => array(
				'label' => __('Download', true),
				'url' => array(
					'admin' => false,
					'action' => 'download'
					)
				),
			'delete' => array(
				'label' => __('Delete', true),
				'confirm' => __('Are you sure?', true)
				)
			),
		'table' => array('class' => 'admin-table')
		);
	$tableCode = $table->render($uploads, $options);
?>
<section id="uploads-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('uploads', 'Uploads', true));?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
				<?php
					echo $this->SimpleFilter->form();
					echo $this->SimpleFilter->contains('Upload.name', array(
						'label' => __d('uploads', 'Name', true)
					));
					echo $this->SimpleFilter->contains('Upload.description', array(
						'label' => __d('uploads', 'Description', true)
					));
					echo $this->SimpleFilter->contains('Upload.type', array(
						'label' => __d('uploads', 'Type', true)
					));
					echo $this->SimpleFilter->contains('Upload.size', array(
						'label' => __d('uploads', 'Size', true)
					));
					echo $this->SimpleFilter->end();
				?>	
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>