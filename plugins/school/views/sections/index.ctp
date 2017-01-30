<?php
	$options = array(
		'columns' => array(
			'title' => array(
				'label' => __d('school', 'Section title', true)
			), 
			'tutor_id' => array(
				'type' => 'switch',
				'switch' => $tutors,
				'label' => __d('school', 'Tutor', true)
			),
			'cycle_id' => array(
				'type' => 'switch',
				'switch' => $cycles,
				'label' => __d('school', 'Cycle', true)
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
	$tableCode = $this->Table->render($sections, $options);
?> 
<section id="sections-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('school', 'Sections', true));?>
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
				echo $this->SimpleFilter->contains('Section.title', array('label' => __d('school', 'Title', true)));
				echo $this->SimpleFilter->options('Section.cantine_group_id', array('options' => $cantineGroups, 'label' => __d('cantine', 'Cantine Group', true)));
				echo $this->SimpleFilter->options('Section.stage_id', array('options' => $stages, 'label' => __d('school', 'Stage', true)));
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