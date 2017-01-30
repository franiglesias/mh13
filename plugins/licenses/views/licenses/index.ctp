<section id="licenses-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('licenses', 'Licenses', true)); ?>
			<?php echo $this->Page->paginator(); ?></h1>
	</header>
	<div class="row">
		<div class="medium-3 columns">
			<div class="mh-admin-widget">
				<a href="<?php echo Router::url(array('action' => 'add')); ?>" class="mh-btn-create"><?php printf(__('Create %s', true), __d('licenses', 'License', true)); ?></a>
			</div>
		</div>
		<div class="medium-9 columns">
			<?php
			// $selectionActions = ClassRegistry::getObject('view')->viewVars['selectionActions'];

			$options = array(
				'columns' => array(
					'license' => array('label' => __d('licenses', 'License', true)), 
					'type' => array('label' => __d('licenses', 'Type', true)), 
				),
				'actions' => array(
					'edit' => array('label' => __('Edit', true)),
					'delete' => array(
						'label' => __('Delete', true), 
						'confirm' => __('Are you sure?', true)
						)
					),
				'table' => array(
					'class' => 'admin-table',
					'selection' => array(
						'url' => array(
							'plugin' => 'licenses',
							'controller' => 'licenses',
							'action' => 'selection'
						),
						'actions' => $selectionActions,
						'all' => true
						)
					)
				);

			echo $this->Table->render($licenses, $options);
			?>
		</div>		
	</div>
</section>