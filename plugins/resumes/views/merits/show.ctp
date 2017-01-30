<?php $this->set('title_for_layout', sprintf(__d('resumes', 'Job application manage %s', true), $meritType['MeritType']['title'])); ?>
<div class="mh-page">
	<header>
		<h1><?php echo $meritType['MeritType']['title']; ?></h1>
		<h2><?php echo $meritType['MeritType']['help']; ?></h2>
	</header>
	<div class="mh-body">
		<!-- Content here -->
		<?php if (!$merits): ?>
		<p><?php __d('resumes', 'You don\'t have any data for this section yet.'); ?></p>
		<?php else: ?>
		<div class="table">
			<?php
			$options = array(
				'columns' => array(
					'start' => array(
						'label' => __d('resumes', 'Start year', true), 
						'attr' => array('class' => 'cell-short cell-number'
					)), 
					'end' => array(
						'label' => __d('resumes', 'End year', true),
						'attr' => array('class' => 'cell-short cell-number'
						)), 
					'title' => array(
						'label' => $meritType['MeritType']['title_label']
					),
					'remarks' => array(
						'label' => $meritType['MeritType']['remarks_label']
					),
				),
				'actions' => array(
					'edit' => array(
						'label' => __('Edit', true), 
						'attr' => array('class' => 'mh-btn-edit')
						),
					'delete' => array(
						'label' => __('Delete', true), 
						'confirm' => __('Are you sure?', true),
						'attr' => array('class' => 'mh-btn-delete')
		 				)
					),
				'table' => array(
					'class' => 'admin-table wide'
					)
				);
			if ($meritType['MeritType']['use_dates'] <= 1) {
				unset($options['columns']['end']);
			}
			if ($meritType['MeritType']['use_dates'] == 0) {
				unset($options['columns']['start']);
			}
			
			echo $this->Table->render($merits, $options);
			echo $this->element('paginators/mh-mini-paginator');
			?>	
		</div>
		<?php endif ?>
		<p><?php echo $this->Html->link(
				__d('resumes', 'Add', true),
				array('action' => 'add', $type),
				array('class' => 'mh-btn-ok right')
				); ?></p>
		

	</div>
</div>

