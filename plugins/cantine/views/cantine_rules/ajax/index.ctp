<?php
$this->Paginator->options(array(
    'update' => '#cantine-rules-list',
    'evalScripts' => true,
	'before' => $this->Js->get('#mh-cantine-rules-busy-indicator')->effect('fadeIn', array('buffer' => false)),
	'complete' => $this->Js->get('#mh-cantine-rules-busy-indicator')->effect('fadeOut', array('buffer' => false)),
));



	$options = array(
		'columns' => array(
			// 'id', 
			// 'cantine_turn_id', 
			'day_of_week' => array(
				'type' => 'days',
				'mode' => 'labor compact'
				), 
			'cantine_group_id' => array(
				'type' => 'switch',
				'switch' => $cantineGroups
			), 
			'extra1' => array(
				'type' => 'rotate', 
				'url' => array('action' => 'rotate1'), 
				'switch' => $states, 
				), 
			'extra2' => array(
				'type' => 'rotate', 
				'url' => array('action' => 'rotate2'), 
				'switch' => $states, 
			), 
 
		),
		'actions' => array(
			'edit' => array(
				'ajax' => array(
					'mh-update' => '#cantine-rule-form',
					'mh-indicator' => '#mh-cantine-rules-busy-indicator'
				),
			),
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true),
				'ajax' => array(
					'mh-update' => '#cantine-rules-list',
					'mh-indicator' => '#mh-cantine-rules-busy-indicator'
				),
			)
		),
			
		'table' => array('class' => 'admin-table')
		);
	$theTable = $this->Table->render($cantineRules, $options);
?> 
<section id="cantineRules-index" class="mh-ajax-admin-panel">
	<header>
		<h1><?php echo __d('cantine', 'Cantine Rules for this turn', true); ?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php
			echo $this->XHtml->ajaxLoading('mh-cantine-rules-busy-indicator');
			echo $theTable;
			echo $this->Js->writeBuffer();
		?>
	</div>
</section>