<?php
	$options = array(
		'columns' => array(
			'title' => array('label' => __d('menus', 'Title', true)), 
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
		
		$tableCode = $this->Table->render($menus, $options);
?>
<section id="menus-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('menus', 'Menu', true));?>
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
			<div class="mh-admin-widget">
				<?php
					echo $this->SimpleFilter->form();
					echo $this->SimpleFilter->contains('Menu.title', array('label' => __d('menus', 'Title', true)));
					echo $this->SimpleFilter->end();
				?>
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>