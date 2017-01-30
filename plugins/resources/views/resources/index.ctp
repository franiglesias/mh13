<?php
	$options = array(
		'columns' => array(
			'Upload.path' => array(
				'type' => 'preview', 
				'label' => __d('resources', 'Preview', true), 
				'attr' => array('class' => 'cell-stretch')
			),
			'title' => array(
				'attr' => array('class' => 'cell-long'),
				'label' => __d('resources', 'Title', true)
			), 
			'Batch.title' => array(
				'label' => __d('resources', 'Batch', true)
			), 
			'Version.version' => array(
				'label' => __d('resources', 'Version', true),
			),
			'user_id' => array(
				'label' => __d('resources', 'Uploader', true),
				'type' => 'switch',
				'switch' => $users,
				'attr' => array('class' => 'cell-medium')
			)
		),
		'actions' => array(
			'download' => array(
				'label' => __('Download', true),
				'argField' => 'Upload.id',
				'url' => array(
					'plugin' => 'uploads',
					'controller' => 'uploads',
					'action' => 'download'
				)
			),
			'editview' => array(
				'type' => 'switch',
				'switchField' => 'Resource.user_id',
				'switch' => array(
					0 => 'view',
					1 => 'edit',
					$user_id => 'edit',
				),
				'default' => ife(!empty($canAdmin), 1, 0),
				'actions' => array(
					'edit' => array(
						'label' => __('Edit', true)
						),
					'view' => array(
						'label' => __('View', true),
						'attr' => array()
					)
				)
			),
			'deleteopt' => array(
				'type' => 'switch',
				'switchField' => 'Resource.user_id',
				'switch' => array(
					0 => '',
					1 => 'delete',
					$user_id => 'delete'
				),
				'default' => ife(!empty($canAdmin), 1, 0),
				'actions' => array(
					'delete' => array(
						'label' => __('Delete', true), 
						'confirm' => __('Are you sure?', true)
						)
					)
				),
   			'upgradeopt' => array(
   				'type' => 'switch',
   				'switchField' => 'Resource.user_id',
   				'switch' => array(
   					0 => '',
   					1 => 'upgrade',
   					$user_id => 'upgrade'
   				),
   				'default' => ife(!empty($canAdmin), 1, 0),
   				'actions' => array(
   					'upgrade' => array(
   						'label' => __d('resources', 'Upload new version', true), 
   						'confirm' => __('Are you sure?', true),
						'attr' => array('class' => 'mh-button-upload')
   						)
   					)
   				)
    	),
		'table' => array('class' => 'admin-table')
		);
?> 
<section id="resources-index" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading"><?php printf(__('Admin %s', true), __d('resources', 'Resources', true)); ?></h1>
		<p class="mh-admin-panel-menu">
		<?php echo $this->Html->link(
			__d('resources', 'Upload new resources', true), 
			array('plugin' => 'resources', 'controller' => 'batches', 'action' => 'add'), 
			array('class' => 'mh-button mh-admin-panel-menu-item mh-button-ok mh-button-add')
		); ?> 
		<?php echo $this->Html->link(
			__d('resources', 'Search', true), 
			array('action' => 'search', 'new'), 
			array('class' => 'mh-button mh-admin-panel-menu-item mh-button-search')
		); ?>
		</p>
		<?php echo $this->element('paginators/mh-mini-paginator'); ?> 
	</header>
	
	<?php
		echo $this->SimpleFilter->form();
		echo $this->SimpleFilter->options('Resource.batch_id', array(
			'options' => $batches, 
			'label' => __d('resources', 'Batch', true)
		));
		echo $this->SimpleFilter->options('Resource.user_id', array(
			'options' => $users, 
			'label' => __d('resources', 'Uploader', true)
		));
		echo $this->SimpleFilter->contains('Resource.title', array(
			'label' => __d('resources', 'Title', true)
		));
		echo $this->SimpleFilter->options('Resource.subject_id', array(
			'options' => $subjects,
			'label' => __d('resources', 'Subject', true)
		));
		echo $this->SimpleFilter->options('Resource.level_id', array(
			'options' => $levels,
			'label' => __d('resources', 'Level', true)
		));
		echo $this->SimpleFilter->contains('Resource.description', array(
			'label' => __d('resources', 'Description', true)
		));
		echo $this->SimpleFilter->contains('Tagged.by', array(
			'label' => __d('resources', 'Tags', true)
		));

		echo $this->SimpleFilter->end();
	?>
	
	
	<div class="mh-admin-panel-body">
		<?php echo $this->Table->render($resources, $options); ?> 
	</div>
</section>