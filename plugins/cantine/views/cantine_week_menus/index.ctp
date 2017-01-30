<?php
$options = array(
	'columns' => array(
		'title' => array('label' => __d('cantine', 'Title', true)), 
		'calories' => array(
			'label' => __d('cantine', 'Calories', true),
			'attr' => array('class' => 'cell-medium cell-number')), 
		'glucides' => array(
			'label' => __d('cantine', 'Glucides', true),
			'attr' => array('class' => 'cell-medium cell-number')), 
		'lipids' => array(
			'label' => __d('cantine', 'Lipids', true),
			'attr' => array('class' => 'cell-medium cell-number')), 
		'proteines' => array(
			'label' => __d('cantine', 'Proteines', true),
			'attr' => array('class' => 'cell-medium cell-number')), 
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
	
	$tableCode = $this->Table->render($cantineWeekMenus, $options);
?>	
<section id="cantineWeekMenu-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('cantine', 'Cantine Menus', true));?>
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
