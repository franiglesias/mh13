<?php
$options = array(
	'columns' => array(
		'title' => array(
			'label' => __d('resumes', 'Merit Type', true)
		), 
		'title_label' => array(
			'label' => __d('resumes', 'Label for title', true),
			'attr' => array('class' => 'cell-long')
		), 
		'remarks_label' => array(
			'label' => __d('resumes', 'Label for remarks', true),
			'attr' => array('class' => 'cell-long')
		), 
		'allow_url' => array(
			'label' => __d('resumes', 'URL', true),
			'type' => 'boolean', 
			'attr' => array('class' => 'cell-short')
		),
		'allow_file' => array(
			'label' => __d('resumes', 'File', true),
			'type' => 'boolean', 
			'attr' => array('class' => 'cell-short')
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

$tableCode = $this->Table->render($meritTypes, $options);

?>	
<section id="meritTypes-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('resumes', 'Merit Types', true));?>
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
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>