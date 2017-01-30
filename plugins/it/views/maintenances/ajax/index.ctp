<?php
	$options = array(
		'columns' => array(
			'description' => array(
				'label' => __d('it', 'Description', true)
			), 
			'maintenance_type_id' => array(
				'type' => 'switch',
				'switch' => $maintenanceTypes,
				'label' => __d('it', 'Type', true)
			),
			'requested' => array(
				'label'=>__d('it', 'Requested', true),
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
				'label' => __d('it', 'Days', true),
				'attr' => array('class' => 'cell-short cell-number')
			),
			'status' => array(
				'type' => 'switch',
				'switch' => $this->Maintenance->statuses,
				'label' => __d('it', 'Status', true)
			), 
			'technician_id' => array(
				'type' => 'switch',
				'switch' => $technicians,
				'label' => __d('it', 'Technician', true)
			)
		),
		'actions' => array(
			'edit' => array(
				'ajax' => array(
					'mh-update' => '#maintenance-form',
					'mh-indicator' => '#mh-maintenances-busy-indicator'
				),
			),
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true),
				'ajax' => array(
					'mh-update' => '#maintenances-list',
					'mh-indicator' => '#mh-maintenances-busy-indicator'
				),

			)
		),
		'table' => array(
			'class' => 'admin-table', 
			'ajax' => array(
				'mh-update' => '#maintenances-list',
				'mh-indicator' => '#mh-maintenances-busy-indicator',
				'mh-reveal' => '#maintenance-form'
			)
		)
	);
	$theTable = $this->Table->render($maintenances, $options);
?> 
<section id="maintenances-index" class="mh-ajax-admin-panel">
	<header>
		<h1><?php echo __d('it', 'Maintenance actions for this device', true); ?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php
			echo $this->XHtml->ajaxLoading('mh-maintenances-busy-indicator');
			echo $theTable;
			echo $this->Js->writeBuffer();
		?>
	</div>
</section>