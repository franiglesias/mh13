<?php
	$options = array(
		'columns' => array(
			'date' => array('attr' => array('class' => 'cell-medium')), 
			'remark', 
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
	$tableCode =  $this->Table->render($cantineDateRemarks, $options);
?>	
<section id="cantineDateRemarks-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('cantine', 'Cantine Date Remarks', true));?>
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
					__d('cantine', 'Manage Menus', true), 
					array('plugin' => 'cantine', 'controller' => 'cantine_week_menus', 'action' => 'index'), 
					array('class' => 'mh-btn-index')
				);
				 ?>

			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>