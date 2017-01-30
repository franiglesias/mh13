<?php
$options = array(
	'columns' => array(
		'photo' => array(
			'attr' => array('class' => 'cell-stretch'),
			'type' => 'preview',
			'label' => __d('resumes', 'Photo', true)
			), 
		'fullname' => array(
			'label' => __d('resumes', 'Full name', true)
			), 
		'modified' => array(
			'type' => 'time',
			'format' => 'j/m/y',
			'attr' => array('class' => 'cell-date'),
			'label' => __d('resumes', 'Last mod.', true)
			)
		),
	'actions' => array(
		'view',
		'delete' => array(
			'label' => __('Delete', true), 
			'confirm' => __('Are you sure?', true)
			)
		),
	'table' => array(
		'class' => 'admin-table'
		)

	);
	$tableCode = $this->Table->render($resumes, $options);
?>
<section id="resumes-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('resumes', 'Resumes', true));?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
				<?php echo $this->Html->link(
					__d('resumes', 'Search', true),
					array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'search'),
					array('class' => 'mh-btn-search')
					);
				 ?>

			</div>
			<div class="mh-admin-widget">
				
				<?php
					echo $this->SimpleFilter->form();
					echo $this->SimpleFilter->contains('Resume.fullname', array('label' => __d('resumes', 'Full name', true)));
					echo $this->SimpleFilter->contains('Merit.title', array('label' => __d('resumes', 'Merit', true)));
					echo $this->SimpleFilter->end();
				?>
			</div>
			
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>
