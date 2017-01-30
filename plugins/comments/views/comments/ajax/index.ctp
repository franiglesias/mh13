<?php
	$options = array(
		'columns' => array(
			'comment' => array('label' => __d('comments', 'Comment', true)), 
			'name' => array('label' => __d('comments', 'Commenter', true)),
			'email' => array('label' => __d('comments', 'Email', true)),
			'approved' => array(
				'class' => 'cell-strech', 
				'type' => 'rotate', 
				'url' => array('action' => 'rotate'), 
				'switch' => $states, 
				'label' => __d('comments', 'Approved', true)
			), 
		),
		'table' => array(
			'class' => 'admin-table',
			'ajax' => array(
				'mh-update' => '#comments-list',
				'mh-indicator' => '#mh-comments-busy-indicator',
				'mh-reveal' => '#comment-form'
			)
		)
	);
	$theTable = $this->Table->render($comments, $options);
?>
<section id="comments-index" class="mh-ajax-admin-panel">
	<header>
		<h1><?php echo __d('comments', 'Admin comments for this Channel', true); ?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php
			echo $this->XHtml->ajaxLoading('mh-comments-busy-indicator');
			echo $theTable;
			echo $this->Js->writeBuffer();
		?>
	</div>
</section>