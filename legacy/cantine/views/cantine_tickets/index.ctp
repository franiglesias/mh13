<?php
	$options = array(
		'columns' => array(
			'CantineTicket.fullname' => array(
				'label' => __d('cantine', 'Full Name', true),
				'attr' => array('class' => 'cell-long')
			),
			'date' => array(
				'label' => __d('cantine', 'Date', true),
				'type' => 'time',
				'format' => 'd-m-Y',
				'attr' => array('class' => 'cell-medium cell-date')
			), 
			'Section.title' => array(
				'label' => __d('cantine', 'Section', true),
				'attr' => array('class' => 'cell-medium')
			),
			// 'Student.remarks' => array(
			// 	'label' => __d('cantine', 'Remarks', true)
			// )
		),
		'actions' => array(
			'edit' => array('label' => __('Edit', true)),
			'duplicate' => array(
				'label' => __('Duplicate', true)
			),
			
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true)
				)
			),
		'table' => array(
			'class' => 'admin-table',
			'selection' => array(
					'url' => array(
						'plugin' => 'cantine',
						'controller' => 'cantine_tickets',
						'action' => 'selection'
					),
					'actions' => $selectionActions,
					'all' => true
				)
			
			)
		);
	$tableCode = $this->Table->render($cantineTickets, $options);
?> 

<section id="cantineTickets-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('cantine', 'Cantine Tickets', true));?>
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
					__d('cantine', 'Manage Incidences', true), 
					array('plugin' => 'cantine', 'controller' => 'cantine_incidences', 'action' => 'index'), 
					array('class' => 'mh-btn-care')
				);
				echo $this->Html->link(
					__d('cantine', 'Attendances for today', true), 
					array('plugin' => 'cantine', 'controller' => 'cantine', 'action' => 'attendances'), 
					array('class' => 'mh-btn-people')
				);
				?>

			</div>
			<div class="mh-admin-widget">
			<?php
				echo $this->SimpleFilter->form();
				echo $this->SimpleFilter->date('CantineTicket.date', array('label' => __d('cantine', 'Date', true)));
				echo $this->SimpleFilter->contains('Student.fullname', array('label' => __d('cantine', 'Student full name', true)));
				echo $this->SimpleFilter->options('Student.section_id', array(
					'label' => __d('cantine', 'Section', true),
					'options' => $sections
				));
			echo $this->SimpleFilter->options('Section.cycle_id', array('options' => $cycles, 'label' => __d('school', 'Cycle', true)));
			echo $this->SimpleFilter->options('Section.level_id', array('options' => $levels, 'label' => __d('school', 'Level', true)));

				echo $this->SimpleFilter->end();
			?>
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>