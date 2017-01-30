<?php

	$options = array(
		'columns' => array(
			'DeviceType.title' => array(
				'label' => __d('it', 'Device Type', true)
			),
			'MaintenanceType.title' => array(
				'label' => __d('it', 'Maintenance Type', true)
			),
			'Technician.title' => array(
				'label' => __d('it', 'Tech', true)
			),
			'Maintenance.actions' => array(
				'label' => __d('it', 'Actions', true),
				'attr' => array('class' => 'cell-number')
			),
			'Maintenance.response_time' => array(
				'label' => __d('it', 'Avg. response', true),
				'attr' => array('class' => 'cell-number'),
				'type' => 'number',
				'precision' => 1
			),
			'Maintenance.min_response_time' => array(
				'label' => __d('it', 'Min', true),
				'attr' => array('class' => 'cell-number'),
				'type' => 'integer'
			),
			'Maintenance.max_response_time' => array(
				'label' => __d('it', 'Max', true),
				'attr' => array('class' => 'cell-number'),
				'type' => 'integer'
			),
			'Maintenance.total_time' => array(
				'label' => __d('it', 'Avg. total', true),
				'attr' => array('class' => 'cell-number'),
				'type' => 'number',
				'precision' => 1
			),
			'Maintenance.min_total_time' => array(
				'label' => __d('it', 'Min', true),
				'attr' => array('class' => 'cell-number'),
				'type' => 'integer'
			),
			'Maintenance.max_total_time' => array(
				'label' => __d('it', 'Max', true),
				'attr' => array('class' => 'cell-number'),
				'type' => 'integer'
			),
			
		),
		'table' => array(
			'class' => 'admin-table full-print-table',
			'break' => false,
			'totals' => false,
			'group' => array(
				0 => 'DeviceType.id',
				1 => 'MaintenanceType.id',
				2 => 'Technician.id'
				)
			)
	);
	
	$tableCode = $this->Table->render($report, $options);
	$range['from'] = $this->Time->format(DATE_SHORT, $range['from']);
	$range['to'] = $this->Time->format(DATE_SHORT, $range['to']);
?>
<section id="maintenanceReport-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__d('it', 'Maintenance report (%s-%s)', true), $range['from'], $range['to']);?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
				<?php 
				echo $this->Html->link(
					__d('cantine', 'Print', true),
					array('action' => 'report', 'print' => true),
					array('class' => 'mh-btn-print', 'target' => '_blank')
				);

				?>
			</div>
			<div class="mh-admin-widget">
				<?php
					echo $this->SimpleFilter->form();
					echo $this->SimpleFilter->dateRange('Maintenance.requested', array(
						'label' => __d('it', 'Date range', true)
					));
					echo $this->SimpleFilter->contains('DeviceType.title', array(
						'label' => __d('it', 'Device Type', true)
					));
					echo $this->SimpleFilter->end();
				?>
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>
