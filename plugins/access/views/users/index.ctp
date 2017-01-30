<?php
	$options = array(
		'columns' => array(
			'realname'=> array(
				'type' => 'compact',
				'extra' => 'User.username',
				'label' => __d('access', 'Real name', true), 
				'attr' => array('class' => 'cell-long'
			)),
			'active' => array(
				'attr' => array('class' => 'cell-short'),
				'label' => __d('access', 'Active', true),
				'type' => 'boolean'
				)
			),
		'actions' => array(
			'edit' => array(
				'label' => __('Edit', true)
			),
			'activation' => array(
				'type' => 'switch',
				'switchField' => 'User.active',
				'switch' => array(
					0 => 'activate',
					1 => 'deactivate',
				),
				'class' => 'mh-btn-action',
				'default' => 0,
				'actions' => array(
					'activate' => array(
						'label' => __d('access', 'Activate', true),
						'confirm' => __('Are you sure?', true)
						),
					'deactivate' => array(
						'label' => __d('access', 'Deactivate', true),
						'confirm' => __('Are you sure?', true)
						),
				)
			),
			
			
			'delete' => array(
				'label' => __('Delete', true),
				'confirm' => __('Are you sure?', true)
 				)
			),
		'table' => array('class' => 'admin-table')
		);
		
	$tableCode = $this->Table->render($users, $options);
?>
<section id="users-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('access', 'Users', true));?>
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
					echo $this->SimpleFilter->contains('User.username', array('label' => __d('access', 'User name', true)));
					echo $this->SimpleFilter->contains('User.realname', array('label' => __d('access', 'Real name', true)));
					echo $this->SimpleFilter->contains('User.email', array('label' => __d('access', 'Email', true)));
					echo $this->SimpleFilter->boolean('User.active', array('label' => __d('access', 'Active', true)));
					echo $this->SimpleFilter->end();
				?>
				
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>

