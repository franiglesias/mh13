<?php
echo $this->Html->css('/contents/css/backend', null, array('inline' => false));
$options = array(
	'columns' => array(
		'title' => array(
			'label' => __d('contents', 'Title', true),
			'type' => 'link',
			'url' => array('action' => 'edit')
			),
		'real_status' => array(
			'attr' => array('class' => 'cell-medium'),
			'label' => __d('contents', 'Status', true),
			'type' => 'status',
			'switch' => $this->Item->shortRealStatuses,
			'statuses' => $this->Item->colorStatuses
			),
		'readings' => array(
			'attr' => array('class' => 'cell-number cell-stretch'),
			'label' => __d('contents', 'Readings', true)	
			),
		'stick' => array(
			'type' => 'toggle',
			'label' => __d('contents', 'Stick?', true),
			'url' => array('plugin' => 'contents', 'controller' => 'items', 'action' => 'toggle')
			)
		),
	'actions' => array(
		'preview' => array(
			'label' => __d('contents', 'Preview', true),
			'attr' => array('class' => 'mh-btn-view', 'target' => '_blank')
		),
		'edit' => array(
			'label' => __('Edit', true),
			),
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
					'plugin' => 'contents',
					'controller' => 'items',
					'action' => 'selection'
				),
				'actions' => $selectionActions,
				'all' => true
			)
		)
	);
	
	if (empty($contentsAdministrator)) {
		unset($options['columns']['home']);
	}
	
	$tableCode = $this->Table->render($items, $options);
?>
<section id="items-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('contents', 'Items', true));?>
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
			<?php //echo $this->Table->selectionWidget(); ?>
			<div class="mh-admin-widget">
				
				<?php
					echo $this->SimpleFilter->form();
					echo $this->SimpleFilter->options('Item.channel_id', array('options' => $filterChannelsOptions, 'label' => __d('contents', 'Channel', true)));
					echo $this->SimpleFilter->contains('I18n__title.content', array('label' => __d('contents', 'Title', true)));
					echo $this->SimpleFilter->date('Item.pubDate', array('label' => __d('contents', 'Publication', true)));
					$levels["0"] = __d('contents', 'No level', true); 
					echo $this->SimpleFilter->options('Item.level_id', array(
						'label' => __d('contents', 'Level', true),
						'options' => $levels,
					));
					echo $this->SimpleFilter->options('Item.real_status', array('options' => $this->Item->realStatuses, 'label' => __d('contents', 'Status', true)));
					echo $this->SimpleFilter->boolean('Item.home', array('label' => __d('contents', 'Home', true)));
					echo $this->SimpleFilter->boolean('Item.featured', array('label' => __d('contents', 'Featured', true)));
					echo $this->SimpleFilter->boolean('Item.stick', array('label' => __d('contents', 'Sticky', true)));
					echo $this->SimpleFilter->end();
				?>
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>
