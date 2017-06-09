<?php
	$options = array(
		'columns' => array(
			'CantineTurn.title' => array(
				'label' => __d('cantine', 'Turn', true),
				'attr' => array('class' => 'cell-short cell-stretch'),
				'display' => false
			),
			'Section.title' => array(
				'label' => __d('cantine', 'Section', true),
				'attr' => array('class' => 'cell-short cell-stretch')
			),
			'Student.fullname' => array(
				'label' => __d('cantine', 'Full Name', true),
				'attr' => array('class' => 'cell-long cell-stretch')
			),
			'Student.remarks' => array(
				'label' => __d('cantine', 'Remarks', true),
			),
			
			// 'CantineIncidence.remark'
		),
		'actions' => null,
		'table' => array(
			'class' => 'admin-table full-print-table',
			'break' => 'CantineTurn.title',
			'totals' => false
			)
		);
	
	$optionsIncidences = array(
		'columns' => array(
			'Student.fullname' => array(
				'label' => __d('cantine', 'Full Name', true),
				'attr' => array('class' => 'cell-long')
			),
			'CantineIncidence.remark' => array(
				'label' => __d('cantine', 'Remarks', true),
			)
		),
		'actions' => null,
		'table' => array(
			'class' => 'full-print-table admin-table',
			'totals' => false
		)
	);
	
	$optionsStats = array(
		'columns' => array(
			'CantineTurn.title'=> array(
				'label' => __d('cantine', 'Turn', true),
				'attr' => array('class' => 'cell-stretch')
			),
			'CantineTurn.attendances' => array(
				'label' => __d('cantine', 'Attendances', true),
				'attr' => array('class' => 'cell-number cell-short cell-stretch')
			),
			'CantineTurn.ei' => array(
				'label' => __d('cantine', 'EI', true),
				'attr' => array('class' => 'cell-number cell-short cell-stretch')
			),
			'CantineTurn.ep' => array(
				'label' => __d('cantine', 'EP', true),
				'attr' => array('class' => 'cell-number cell-short cell-stretch')
			),
			'CantineTurn.eso' => array(
				'label' => __d('cantine', 'ESO', true),
				'attr' => array('class' => 'cell-number cell-short cell-stretch')
			),
			'CantineTurn.bac' => array(
				'label' => __d('cantine', 'Bac', true),
				'attr' => array('class' => 'cell-number cell-short cell-stretch')
			),
		),
		'table' => array(
			'totals' => array('CantineTurn.attendances', 'CantineTurn.ei', 'CantineTurn.ep', 'CantineTurn.eso', 'CantineTurn.bac'),
			'class' => 'admin-table',
			'model' => 'CantineTurn'
		)
	);

?>
<section id="attendances-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__d('cantine', 'Cantine Attendance List for %s', true), $this->Time->format('j-m-Y', $date));?>
			<span><?php //echo $this->element('paginators/mh-mini-paginator'); ?> 
			</span>
		</h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
				<?php
					echo $this->Html->link(
						__d('cantine', 'Add Ticket', true), 
						array('plugin' => 'cantine', 'controller' => 'cantine_tickets', 'action' => 'add'), 
						array('class' => 'mh-btn-create')
					);
					echo $this->Html->link(
						__d('cantine', 'Manage Tickets', true), 
						array('plugin' => 'cantine', 'controller' => 'cantine_tickets', 'action' => 'index'), 
						array('class' => 'mh-btn-index')
					);
					echo $this->Html->link(
						__d('cantine', 'Add Incidence', true), 
						array('plugin' => 'cantine', 'controller' => 'cantine_incidences', 'action' => 'add'), 
						array('class' => 'mh-btn-create')
					);
					echo $this->Html->link(
						__d('cantine', 'Manage Incidences', true), 
						array('plugin' => 'cantine', 'controller' => 'cantine_incidences', 'action' => 'index'), 
						array('class' => 'mh-btn-index')
					);
					echo $this->Html->link(
						__d('cantine', 'Print', true),
						array('action' => 'attendances', 'print' => true),
						array('class' => 'mh-btn-print', 'target' => '_blank')
					);
				?>
			</div>
			<?php echo $this->Table->selectionForm(); ?>
			<div class="mh-admin-widget">
			<?php
				echo $this->SimpleFilter->form();
				echo $this->SimpleFilter->date('Attendance.date');
				echo $this->SimpleFilter->end();
			?></div>
		</div>
		<div class="small-12 medium-9 columns">
			<h2 class="subheading"><?php __d('cantine', 'Attendances'); ?></h2>
			<?php echo $this->Table->render($stats, $optionsStats); ?>
			<h2 class="subheading"><?php __d('cantine', 'Incidences'); ?></h2>
			<?php echo $this->Table->render($incidences, $optionsIncidences); ?>
			<h2 class="page-break-before subheading"><?php __d('cantine', 'Attendances list'); ?></h2>
			<?php echo $this->Table->render($attendances, $options); ?> 
		</div>		
	</div>
</section>