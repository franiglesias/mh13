<?php
	$options = array(
		'columns' => array(
			'Bar.id' => array('label' => __d('menus', 'Id', true)), 
			'Bar.title' => array('label' => __d('menus', 'Title', true)), 
			'Bar.label' => array('label' => __d('menus', 'Label', true)), 
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
	$tableCode = $this->Table->render($bars, $options);
?>

<section id="bars-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('access', 'Bar', true));?>
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