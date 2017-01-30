<?php
echo $this->Html->css('/contents/css/backend', null, array('inline' => false));
	$options = array(
		'columns' => array(
			'title' => array(
				'label' => __d('contents', 'Title', true),
				'type' => 'link',
				'url' => array('action' => 'edit'),
				'attr' => array('class' => 'cell-long')
				),
			'active' => array(
				'label' => __d('contents', 'Active', true), 
				'type' => 'boolean',
				'attr' => array('class' => 'cell-short')
				), 
			'external' => array(
				'label' => __d('contents', 'External', true),
				'type' => 'toggle',
				'url' => array(
					'action' => 'toggle'
				),
				
				'attr' => array('class' => 'cell-short cell-toggle')
			)
			),
		'actions' => array(
			'edit'  => array('label' => __('Edit', true)),
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
						'controller' => 'channels',
						'action' => 'selection'
					),
					'actions' => $selectionActions,
					'all' => true
				)
			
			)
		);
		$tableCode = $this->Table->render($channels, $options);
?>
<section id="channels-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('contents', 'Channels', true));?>
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
				echo $this->SimpleFilter->contains('I18n__title.content', array('label' => __d('contents', 'Title', true)));
				echo $this->SimpleFilter->boolean('Channel.active', array('label' => __d('contents', 'Active', true)));
				echo $this->SimpleFilter->end();
			?>
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>

