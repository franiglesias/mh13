<?php
	$options = array(
		'columns' => array(
			'Circular.title' => array(
				'type' => 'compact',
				'label' => __d('circulars', 'Title', true),
				'attr' => array('class' => 'cell-long'),
				'extra' => array(
					'Circular.addressee',
				)
			),
			'Circular.circular_type_id' => array(
				'display' => false,
				'label' => __d('circulars', 'Type', true),
				'type' => 'switch',
				'switch' => $typeOptions,
				'attr' => array('class' => 'cell-medium')
			), 
			'Circular.pubDate' => array(
				'type' => 'time',
				'format' => DATE_SHORT,
				'attr' => array('class' => 'cell-date cell-stretch')
			),
			'status' => array(
				'label' => __d('circulars', 'Status', true),
				'type' => 'status',
				'statuses' => $this->Circular->colorStatuses,
				'switch' => $this->Circular->shortStatusOptions,
				'attr' => array('class' => 'cell-stretch')
			), 
			'web' => array(
				'label' => __d('circulars', 'Web', true),
				'type' => 'toggle',
				'url' => array(
					'action' => 'toggle'
				),
				'attr' => array('class' => 'cell-stretch')
				
			)
		),
		'actions' => array(
			'editcircular' => array(
				'type' => 'switch',
				'switchField' => 'Circular.status',
				'switch' => array(
					0 => 'edit',
					1 => 'review',
					2 => 'review',
					3 => 'review'
				),
				'default' => 0,
				'actions' => array(
					'edit' => array(
						'label' => __('Edit', true)
						),
					'review' => array(
						'label' => __('View', true),
						'attr' => array('target' => '_blank', 'class' => 'mh-btn-view')
					)
				)
			),
			'nextstep' => array(
				'type' => 'switch',
				'switchField' => 'Circular.status',
				'switch' => array(
					0 => 'publish',
					1 => 'archive',
					2 => null,
					3 => null
				),
				'default' => 2,
				'actions' => array(
					'publish' => array(
						'url' => array('action' => 'next'),
						'label' => __d('circulars', 'Publish', true),
						'attr' => array('class' => 'mh-btn-view')
					),
					'archive' => array(
						'url' => array('action' => 'next'),
						'label' => __d('circulars', 'Archive', true),
						'attr' => array('class' => 'mh-btn-view')
					),
					
				)
			),
			
			'duplicate' => array(
				'label' => __('Duplicate', true)
			),
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true)
				)
			),
		'table' => array('class' => 'admin-table')
		);
		
	if ($actionsSet == 'supervisor') {
		$options['actions'] = array(
			'editcircular' => array(
				'type' => 'switch',
				'switchField' => 'Circular.status',
				'switch' => array(
					0 => 'edit',
					1 => 'review',
					2 => 'review',
					3 => 'review'
				),
				'default' => 0,
				'actions' => array(
					'edit' => array(
						'label' => __('Edit', true)
						),
					'review' => array(
						'label' => __('View', true),
						'attr' => array('target' => '_blank', 'class' => 'mh-btn-view')
					)
				)
			),
			'nextstep' => array(
				'type' => 'switch',
				'switchField' => 'Circular.status',
				'switch' => array(
					0 => 'publish',
					1 => 'archive',
					2 => null,
					3 => null
				),
				'default' => 2,
				'actions' => array(
					'publish' => array(
						'url' => array('action' => 'next'),
						'label' => __d('circulars', 'Publish', true),
						'attr' => array('class' => 'mh-btn-view')
					),
					'archive' => array(
						'url' => array('action' => 'next'),
						'label' => __d('circulars', 'Archive', true),
						'attr' => array('class' => 'mh-btn-view')
					),
					
				)
			),
			'duplicate' => array(
				'label' => __('Duplicate', true)
			),
			
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true)
				)
			);
	}
	
	$tableCode = $this->Table->render($circulars, $options);
?> 
<section id="circular-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('circulars', 'Circulars', true));?>
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
					echo $this->SimpleFilter->contains('I18n__addressee.content', array(
						'label' => __d('circulars', 'Addressee', true)
					));
					echo $this->SimpleFilter->options('Circular.status', array(
						'options' => $this->Circular->statusOptions,
						'label' => __d('circulars', 'Status', true)
					));
					echo $this->SimpleFilter->options('Circular.circular_type_id', array(
						'options' => $typeOptions,
						'label' => __d('circulars', 'Type', true)
					));
					echo $this->SimpleFilter->date('Circular.pubDate', array(
						'label' => __d('circulars', 'Publication', true)
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