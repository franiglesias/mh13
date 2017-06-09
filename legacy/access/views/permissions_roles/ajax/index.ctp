<?php

$options = array(
	'columns' => array(
		'permission_id' => array(
			'label' => __d('access', 'Permission', true),
			'type' => 'switch',
			'switch' => $permissionsList,
		), 
		'access' => array(
			'label' => __d('access', 'Access', true),
			'attr' => array('class' => 'cell-short'),
			'type' => 'boolean'
			), 
		),
	'actions' => array(
		'edit' => array(
			'ajax' => array(
				'mh-update' => '#permissions-role-form',
				'mh-indicator' => '#mh-permissions-roles-busy-indicator',
			),
		),
		'delete' => array(
			'label' => __('Delete', true), 
			'confirm' => __('Are you sure?', true),
			'ajax' => array(
				'mh-update' => '#permissions-roles-list',
				'mh-indicator' => '#mh-permissions-roles-busy-indicator',
			),
		)
	),
	'table' => array(
		'class' => 'admin-table', 
		'ajax' => array(
			'mh-update' => '#permissions-roles-list',
			'mh-indicator' => '#mh-permissions-roles-busy-indicator',
			'mh-reveal' => '#permissions-role-form'
			)
	));
	$theTable = $this->Table->render($PermissionsRoles, $options);
?>
<section id="permissions-roles-index" class="mh-ajax-admin-panel">
	<header>
		<h1><?php echo __d('access', 'Permissions for role', true); ?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php
			echo $this->XHtml->ajaxLoading('mh-permissions-roles-busy-indicator');
			echo $theTable;
			echo $this->Js->writeBuffer();
		?>
	</div>
</section>
