<?php
	$options = array(
		'columns' => array(
			'File.path' => array(
				'type' => 'preview', 
				'label' => __d('resources', 'Preview', true), 
				'attr' => array('class' => 'cell-stretch')
			),
			'title' => array(
				'attr' => array('class' => 'cell-long'),
				'label' => __d('resources', 'Title', true)
			), 
			'description' => array(
				'label' => __d('resources', 'Description', true)
			), 
		),
		'actions' => array(
			'view' => array(
				'label' => __('View', true)
			),
			'download' => array(
				'label' => __('Download', true),
				'argField' => 'File.id',
				'url' => array(
					'plugin' => 'uploads',
					'controller' => 'uploads',
					'action' => 'download'
				)
			),
		),
		'table' => array('class' => 'admin-table')
		);
?> 
<section id="resources-index" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading"><?php printf(__('Search results for term "%s"', true), $term); ?></h1>
		<p class="mh-admin-panel-menu">
			<?php  echo $this->Html->link(
				__('Admin', true),
				array('action' => 'index'),
				array('class' => 'mh-button mh-admin-panel-menu-item mh-button-back')
			);?> 

			<?php echo $this->Html->link(
				__d('resources', 'New search', true), 
				array('action' => 'search', 'new'), 
				array('class' => 'mh-button mh-admin-panel-menu-item mh-button-ok mh-button-search')
			); ?> 
			
		</p>
		<?php echo $this->element('paginators/mh-mini-paginator'); ?> 
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Table->render($resources, $options); ?> 
	</div>
</section>