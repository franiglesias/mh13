<?php
echo $this->Html->css('/contents/css/backend', null, array('inline' => false));
	$options = array(
		'columns' => array(
			'title' => array(
				'type' => 'link',
				'url' => array('action' => 'edit')
			),
			'slug' => array(
				'label' => __d('contents', 'Preview', true),
				'type' => 'link',
				'url' => array('plugin' => 'contents', 'controller' => 'static_pages', 'action' => 'view'),
				'argField' => 'slug',
				'attr' => array('class' => 'cell-preview', 'target' => '_blank')
			),
			'project_key' => array(
				'label' => __d('contents', 'Project Label', true),
				'type' => 'switch',
				'switch' => $globalLabels,
				'attr' => array('class' => 'cell-stretch')
			)
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
	$tableCode = $this->Table->render($staticPages, $options);
?> 
<section id="staticPages-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('contents', 'Static Pages', true));?>
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
				echo $this->SimpleFilter->options('StaticPage.parent_id', array('label' => __d('contents', 'Parent Page', true),'options' => $allPages));
				echo $this->SimpleFilter->end();
			?>			
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>
