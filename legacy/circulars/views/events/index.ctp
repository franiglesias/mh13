<?php
	$options = array(
		'columns' => array(
			'startDate' => array(
				'type' => 'time',
				'format' => 'j/m/y',
				'label' => __d('circulars', 'Start Date', true),
				'attr' => array('class' => 'cell-date cell-stretch')
			), 
			'endDate' => array(
				'type' => 'time',
				'format' => 'j/m/y',
				'label' => __d('circulars', 'End Date', true),
				'attr' => array('class' => 'cell-date cell-stretch')
			), 
			'title' => array(
				'label' => __d('circulars', 'Title', true)
			), 
			'publish' => array(
				'label' => __d('circulars', 'Publish', true),
				'type' => 'boolean'
			)
			// 'description', 
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
	$tableCode = $this->Table->render($events, $options);
?> 
<section id="events-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('circulars', 'Events', true));?>
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
					echo $this->SimpleFilter->contains('I18n__title.content', array(
						'label' => __d('circulars', 'Title', true)
					));
					echo $this->SimpleFilter->greater('Event.startDate', array(
						'label' => __d('circulars', 'Start Date', true),
						'dataType' => 'date'
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