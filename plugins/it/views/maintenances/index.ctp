<?php
	$options = array(
		'columns' => array(
			'Device.title' => array(
				'label' => __d('it', 'Device', true),
				'display' => false,
			),
			'maintenance_type_id' => array(
				'type' => 'switch',
				'switch' => $maintenanceTypes,
				'display' => false
			),
			'description' => array(
				'label' => __d('it', 'Description', true)
			), 
			'requested' => array(
				'label'=>__d('it', 'Opened', true),
				'type' => 'time',
				'format' => 'j/m/y',
				'attr' => array('class' => 'cell-short cell-date')
			), 
			'resolved' => array(
				'label'=>__d('it', 'Resolved', true),
				'type' => 'time',
				'format' => 'j/m/y',
				'attr' => array('class' => 'cell-short cell-date')
			), 
			'days' => array(
				'label' => __d('it', 'Days', true)
			),
			'status' => array(
				'type' => 'switch',
				'switch' => $this->Maintenance->statuses
			), 
		),
		'actions' => array(
			'edit' => array('label' => __('Edit', true)),
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true)
				)
			),
		'table' => array(
			'class' => 'admin-table',
			'break' => 'Device.title'
			)
		);
	$tableCode = $this->Table->render($maintenances, $options);
?> 
<section id="maintenances-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('it', 'Maintenances', true));?>
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
				echo $this->SimpleFilter->dateRange('Maintenance.requested');
				echo $this->SimpleFilter->contains('Device.title');
				echo $this->SimpleFilter->range('Maintenance.delay');
				echo $this->SimpleFilter->end();
			?>
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>