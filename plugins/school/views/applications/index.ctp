<?php
	$options = array(
		'columns' => array(
			'type' => array(
				'type' => 'switch',
				'switch' => $this->Application->types,
				'label' => __d('school', 'Type', true)
			),
			'student' => array(
				'label' => __d('school', 'Student', true)
			), 
			'level_id' => array(
				'type' => 'switch',
				'switch' => $this->Application->levels,
				'label' => __d('school', 'Level', true)
			), 
			'group' => array(
				'type' => 'switch',
				'switch' => $this->Application->sections,
				'label' => __d('school', 'Group', true)
			), 
			'status' => array(
				'type' => 'switch',
				'switch' => $this->Application->statuses,
				'label' => __d('school', 'Status', true)
			), 
			'resolution' => array(
				'type' => 'switch',
				'switch' => $this->Application->resolutions,
				'label' => __d('school', 'Resolution', true)
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
	$tableCode = $this->Table->render($applications, $options);
?>
<section id="applcations-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('school', 'Applications', true));?>
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
				echo $this->SimpleFilter->contains('Application.student', array(
					'label' => __d('school', 'Student', true)
				));
				echo $this->SimpleFilter->options('Application.type', array(
					'options' => $this->Application->types,
					'label' => __d('school', 'Type', true)
				));
				echo $this->SimpleFilter->options('Application.level', array(
					'options' => $this->Application->levels,
					'label' => __d('school', 'Level', true)
				));
				echo $this->SimpleFilter->options('Application.group', array(
					'options' => $this->Application->sections,
					'label' => __d('school', 'Group', true)
				));
				echo $this->SimpleFilter->options('Application.status', array(
					'options' => $this->Application->statuses,
					'label' => __d('school', 'Status', true)
				));
				echo $this->SimpleFilter->options('Application.resolution', array(
					'options' => $this->Application->resolutions,
					'label' => __d('school', 'Resolution', true)
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