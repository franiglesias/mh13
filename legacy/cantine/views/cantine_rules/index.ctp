<?php
	$options = array(
		'columns' => array(
			'id', 
			'cantine_turn_id' => array(
				'type' => 'switch',
				'switch' => $cantineTurns
			), 
			'day_of_week' => array(
				'type' => 'days',
				'mode' => 'labor compact'
				), 
			'cantine_group_id' => array(
				'type' => 'switch',
				'switch' => $cantineGroups
			), 
			'extra1' => array(
				'type' => 'boolean',
				), 
			'extra2' => array(
				'type' => 'boolean'
			), 
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
	$tableCode =$this->Table->render($cantineRules, $options);
?> 
<section id="cantineRules-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('cantine', 'Cantine Rules', true));?>
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