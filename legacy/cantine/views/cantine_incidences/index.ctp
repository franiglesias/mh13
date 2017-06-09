<?php
	$options = array(
		'columns' => array(
			'CantineIncidence.fullname' => array(
				'label' => __d('cantine', 'Full name', true),
				'attr' => array('class' => 'cell-long')
			),
			'Section.title' => array(
				'label' => __d('cantine', 'Section', true),
				'attr' => array('class' => 'cell-medium')
			),
			'date' => array(
				'label' => __d('cantine', 'Date', true),
				'attr' => array('class' => 'cell-medium cell-date'),
				'type' => 'time',
				'format' => 'd-m-Y',
			), 
			'remark' => array(
				'label' => __d('cantine', 'Remarks', true),
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
	$tableCode = $this->Table->render($cantineIncidences, $options);
?> 

<section id="cantineIncidences-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('cantine', 'Cantine Incidences', true));?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
				<?php 
					echo $this->Html->link(
						__('Add', true), 
						array('action' => 'add'), 
						array('class' => 'mh-btn-create')
					); 
					echo $this->Html->link(
						__d('cantine', 'Manage Tickets', true), 
						array('plugin' => 'cantine', 'controller' => 'cantine_tickets', 'action' => 'index'), 
						array('class' => 'mh-btn-index')
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
				echo $this->SimpleFilter->date('CantineIncidence.date', array('label' => __d('cantine', 'Date', true)));
				echo $this->SimpleFilter->contains('Student.fullname', array('label' => __d('cantine', 'Student full name', true)));
				echo $this->SimpleFilter->end();
			?>
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>