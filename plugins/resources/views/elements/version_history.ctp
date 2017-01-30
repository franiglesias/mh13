<?php if (empty($versions)): ?>
<p><?php __d('resources', 'There is not history of versions'); ?></p>
<?php else: ?>
	
<?php
	$options = array(
		'columns' => array(
			'version' => array(
				'label' => __d('resources', 'Version', true),
				'attr' => array('class' => 'cell-stretch cell-number'),
				'sortable' => false
			),
			'comment' => array(
				'label' => __d('resources', 'Comment', true),
				'attr' => array('class' => 'cell-long'),
				'sortable' => false
			),
			'created' => array(
				'label' => __d('resources', 'Version date', true),
				'type' => 'time',
				'format' => 'j-m-y H:i',
				'sortable' => false
			)
		),
		'table' => array(
			'model' => 'Version'
		),
		'actions' => array(
			'delete' => array(
				'type' => 'switch',
				'switchField' => 'Version.version',
				'default' => 0,
				'switch' => array(
					0 => 'delete_version',
					$current => ''
				),
				'actions' => array(
					'delete_version' => array(
						'label' => __('Delete', true),
						'attr' => array('class' => 'mh-button-delete'),
						'confirm' => __('Are you sure?', true),
						'ajax' => array(
							'update' => '#version-history',
							'beforeSend' => '$("#busy-indicator").fadeIn()',
							'complete' => array(
								'url' => array('action' => 'current'),
								'argField' => 'Version.resource_id',
								'update' => '#resource-metadata',
								'complete' => '$("#busy-indicator").fadeOut()'
								)
							)		
						),
				)
			),
			'revert' => array(
				'type' => 'switch',
				'switchField' => 'Version.version',
				'default' => 0,
				'switch' => array(
					0 => 'revert',
					$current => ''
				),
				'actions' => array(
					'revert' => array(
						'url' => array('action' => 'revert', 0 => $versions[0]['resource_id']),
						'ajax' => array(
							'update' => '#version-history',
							'beforeSend' => '$("#busy-indicator").fadeIn()',
							'evalScripts' => true,
							'complete' => array(
								'url' => array('action' => 'current'),
								'argField' => 'Version.resource_id',
								'update' => '#resource-metadata',
								'complete' => '$("#busy-indicator").fadeOut()'
								)
							)
						)
				)
			)
		)
	);
	if (empty($admin)) {
		unset($options['actions']);
	}
?>
<div class="mh-admin-panel-body">
	<?php
		echo $this->XHtml->ajaxLoading();
		echo $this->Table->render($versions, $options);
		echo $this->Js->writeBuffer();
	?>
</div>

<?php endif ?>
