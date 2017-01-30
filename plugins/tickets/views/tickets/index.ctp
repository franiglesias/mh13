<?php
	$options = array(
		'columns' => array(
			'id', 
			'created' => array(
				'label' => __d('tickets', 'Created', true),
				'type' => 'time',
				'format' => 'Y-m-d H:i'
			), 
			'expiration' => array(
				'label' => __d('tickets', 'Expires', true),
				'type' => 'time',
				'format' => 'Y-m-d H:i'
				
			), 
			'action' => array(
				'label' => __d('tickets', 'Action', true),
				'type' => 'compact',
				'extra' => array('Ticket.model', 'Ticket.foreign_key')
			), 
			'used' => array(
				'label' => __d('tickets', 'Used', true),
				'type' => 'boolean'
			), 
		),
		'actions' => array(
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true)
				)
			),
		'table' => array('class' => 'admin-table')
		);
		
	$tableCode = $this->Table->render($tickets, $options);
?> 

<section id="tickets-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('tickets', 'Tickets', true));?>
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
					echo $this->SimpleFilter->options('Ticket.filter', array(
						'options' => array(
							'pending' => __d('tickets', 'Pending', true),
							'expired' => __d('tickets', 'Expired', true),
							'used' => __d('tickets', 'Used', true)
						),
						'label' => __d('tickets', 'Status', true)
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
	
