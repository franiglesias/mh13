<?php
	$options = array(
		'columns' => array(
			'CantineRegular.fullname' => array(
				'label' => __d('cantine', 'Student', true),
				'attr' => array('class' => 'cell-long')
			),
			'Section.title' => array(
				'label' => __d('cantine', 'Section', true),
				'attr' => array('class' => 'cell-medium'),
				'display' => false
			),
			'CantineRegular.month' => array(
				'label' => __d('cantine', 'Month', true),
				'type' => 'switch',
				'switch' => $months,
				'attr' => array('class' => 'cell-medium cell-date')
			), 
			'CantineRegular.days_of_week' => array(
				'label' => __d('cantine', 'Week days', true),
				'type' => 'days',
				'mode' => 'labor compact',
				'attr' => array('class' => 'cell-stretch cell-date')
				), 
			'Student.extra1' => array(
				'label' => __d('cantine', 'Extra1', true),
				'type' => 'days',
				'mode' => 'labor compact',
				'attr' => array('class' => 'cell-stretch cell-date')
			),
			'CantineRegular.total_days' => array(
				'label' => __d('cantine', 'Total', true),
				'attr' => array('class' => 'cell-short cell-number')
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
			'class' => 'admin-table full-print-table',
			'break' => 'Section.title',
			'selection' => array(
					'url' => array(
						'plugin' => 'cantine',
						'controller' => 'cantine_regulars',
						'action' => 'selection'
					),
					'actions' => $selectionActions,
					'all' => true
				)
			)
		);
	
	if ($report) {
		unset($options['actions']);
		unset($options['table']['selection']);
	} else {
		$options['columns']['Student.extra1']['display'] = false;
		$options['columns']['Section.title']['display'] = false;
	}
	$tableCode = $this->Table->render($cantineRegulars, $options);
		
?> 
<section id="cantineRegulars-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('cantine', 'Cantine Regulars', true));?>
			<?php if (!$report): ?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
			<?php endif; ?>
		</h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
				<?php if ($report) {
					echo $this->Html->link(
						__d('cantine', 'Manage', true), 
						array('action' => 'index'), 
						array('class' => 'mh-btn-index')
					);
					echo $this->Html->link(
						__('Print', true), 
						array('action' => 'index', 'report' => 1, 'print' => 1), 
						array('class' => 'mh-btn-print', 'target' => '_blank')
					);
					echo $this->Html->link(
						__d('cantine', 'Download CSV', true), 
						array('action' => 'index', 'ext' => 'csv', 'report' => 1), 
						array('class' => 'mh-btn-download')
					);
				} else {
					echo $this->Html->link(
						__('Add', true), 
						array('action' => 'add'), 
						array('class' => 'mh-btn-create')
					);
					echo $this->Html->link(
						__d('cantine', 'Invoicing', true), 
						array('action' => 'index', 'report' => 1), 
						array('class' => 'mh-btn-print')
					);
				}
				?> 
			</div>
			<?php if (!$report): ?>
			<div class="mh-admin-widget">
			<?php
				echo $this->SimpleFilter->form();
				echo $this->SimpleFilter->options('CantineRegular.month', array(
					'options' => $months, 
					'label' => __d('cantine', 'Month', true)
				));
				echo $this->SimpleFilter->contains('Student.fullname', array(
					'label' => __d('cantine', 'Student full name', true)
				));
				echo $this->SimpleFilter->options('Student.section_id', array(
					'label' => __d('cantine', 'Section', true),
					'options' => $sections
				));
				echo $this->SimpleFilter->options('Section.cycle_id', array('options' => $cycles, 'label' => __d('school', 'Cycle', true)));
				echo $this->SimpleFilter->options('Section.level_id', array('options' => $levels, 'label' => __d('school', 'Level', true)));

				echo $this->SimpleFilter->end();
			?>
			</div>
			<?php endif ?>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>