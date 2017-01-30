<?php
	$options = array(
		'columns' => array(
			'id', 
			'title', 
			'description', 
			'user_id', 
		),
		'actions' => array(
			'edit' => array('label' => __('Edit', true)),
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true)
				)
			),
		'table' => array('class' => 'admin-table')
		);
?> 
<section id="batches-index" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading"><?php printf(__('Admin %s', true), __d('resources', 'Batches', true)); ?></h1>
		<p class="mh-admin-panel-menu">
		<?php echo $this->Html->link(
			__('Add', true), 
			array('action' => 'add'), 
			array('class' => 'mh-button mh-admin-panel-menu-item mh-button-ok mh-button-add')
		); ?> 
		</p>
		<?php echo $this->element('paginators/mh-mini-paginator'); ?> 
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Table->render($batches, $options); ?> 
	</div>
</section>