<?php
	$options = array(
		'columns' => array(
			'id', 
			'title', 
			'coordinator_id' => array(
				'label' => __d('school', 'Coordinated by', true),
				'switch' => $coordinators
			)
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
	$tableCode = $this->Table->render($cycles, $options);
?> 
<section id="cycles-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('school', 'Cycles', true));?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
				<?php echo $this->Html->link(
					__('Add', true), 
					array('action' => 'add'), 
					array('class' => 'mh-btn-create')
				); ?>

			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>