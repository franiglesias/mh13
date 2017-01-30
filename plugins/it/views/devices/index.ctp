<?php
	$options = array(
		'columns' => array(
			'title' => array(
				'label' => __d('it', 'Device', true)
			), 
			'device_type_id' => array(
				'type' => 'switch',
				'switch' => $deviceTypes,
				'label' => __d('it', 'Type', true)
			), 
			'location' => array(
				'label' => __d('it', 'Location', true)
			), 
			'status' => array(
				'type' => 'status',
				'statuses' => $this->Device->colorStatuses,
				'switch' => $this->Device->shortStatuses,
				'label' => __d('it', 'Status', true)
			), 
			// 'status_remark' => array(
			// 	'label' => __d('it', 'Remarks', true)
			// )
		),
		'actions' => array(
			'edit' => array('label' => __('Edit', true)),
			'duplicate' => array('label' => __('Duplicate', true)),
			'retire' => array(
				'label' => __d('it', 'Retire', true),
				'attr' => array('class' => 'mh-btn-delete')
				),
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true)
				)
			),
		'table' => array('class' => 'admin-table')
		);
	$tableCode = $this->Table->render($devices, $options); 
?> 
<section id="devices-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('it', 'Devices', true));?>
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
				echo $this->SimpleFilter->contains('Device.title', array(
					'label' => __d('it', 'Device', true)
				));
				echo $this->SimpleFilter->contains('Device.identifier', array(
					'label' => __d('it', 'Identifier', true)
				));
				echo $this->SimpleFilter->options('Device.device_type_id', array(
					'options' => $deviceTypes,
					'label' => __d('it', 'Type', true)
				));
				echo $this->SimpleFilter->options('Device.status', array(
					'options' => $this->Device->statuses,
					'label' => __d('it', 'Status', true)
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