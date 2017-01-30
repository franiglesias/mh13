<?php
$options = array(
	'columns' => array(
		'title' => array('label' => __d('aggregator', 'Title', true)), 
		'updated' =>  array('attr' => array('class' => 'cell-date cell-long'), 'label' => __d('aggregator', 'Updated', true)), 
		'approved' => array(
			'label' => __d('aggregator', 'Status', true),
			'attr' => array('class' => 'cell-short'),
			'type' => 'boolean',
			),
		
		'error' => array(
			'label' => __d('aggregator', 'Error', true),
			'attr' => array('class' => 'cell-short'),
			'type' => 'error',
			)
		),
	'actions' => array(
		'edit' => array('label' => __('Edit', true)),
		'refresh' => array('label' => __d('aggregator', 'Refresh', true)),
		'delete' => array(
			'label' => __('Delete', true), 
			'confirm' => __('Are you sure?', true)
			)
		),
	'table' => array('class' => 'admin-table')
	);
if (!empty($waiting)) {
	$options['actions']['approve'] = array('label' => __d('aggregator', 'Approve', true));
}
	$tableCode = $this->Table->render($feeds, $options);
?>
<section id="feed-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('aggregator', 'Feeds', true));?>
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
					__d('aggregator', 'Waiting for approval', true),
					array('action' => 'index', 'waiting'),
					array('class' => 'mh-btn-index')
					);
				echo $this->Html->link(
					__d('aggregator', 'All', true),
					array('action' => 'index'),
					array('class' => 'mh-btn-index')
					);
				?>

			</div>
			<div class="mh-admin-widget">
				<?php

					echo $this->SimpleFilter->form();
					echo $this->SimpleFilter->contains('Feed.title', array('label' => __d('aggregator', 'Title', true)));
					echo $this->SimpleFilter->options('Feed.planet_id', array('options' => $planets, 'label' => __d('aggregator', 'Planet', true)));
					echo $this->SimpleFilter->boolean('Feed.approved', array('label' => __d('aggregator', 'Status', true)));
					echo $this->SimpleFilter->boolean('Feed.error', array('label' => __d('aggregator', 'Error', true)));
					echo $this->SimpleFilter->end();
				?>
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>