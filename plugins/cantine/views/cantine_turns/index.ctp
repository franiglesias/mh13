<?php
	$options = array(
		'columns' => array(
			'title' => array(
				'label' => __d('cantine', 'Turn', true),
				'type' => 'link',
				'url' => array('action' => 'edit')
				
				), 
			'slot' => array('label' => __d('cantine', 'Slot', true)), 
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
	$tableCode = $this->Table->render($cantineTurns, $options);
?> 
<section id="cantineTurns-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('cantine', 'Cantine Turns', true));?>
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
				); 
				echo $this->Html->link(
					__d('cantine', 'Manage Cantine Groups', true), 
					array('plugin' => 'cantine', 'controller' => 'cantine_groups', 'action' => 'index'), 
					array('class' => 'mh-btn-people')
				);
				?>

			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>