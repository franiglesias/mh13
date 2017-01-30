<?php
	$options = array(
		'columns' => array(
			'comment' => array('label' => __d('comments', 'Comment', true)), 
			'approved' => array(
				'class' => 'cell-strech', 
				'type' => 'rotate', 
				'url' => array('action' => 'rotate'), 
				'switch' => $states,
				'label' => __d('comments', 'Approved', true)
				), 
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
		
	$tableCode = $this->Table->render($comments, $options);
?> 

<section id="comments-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('comments', 'Comments', true));?>
			<span><?php echo $this->element('paginators/mh-mini-paginator'); ?></span>
		</h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
				<?php 
				echo $this->Html->link(
					__('Add', true), 
					array('action' => 'add'), 
					array('class' => 'mh-btn-create')
				); 
				echo $this->Html->link(
					__d('comments', 'Purgue Moderated Comments', true),
					array('action' => 'purgue'),
					array('class' => 'mh-btn-delete')
				);
				
				?>

			</div>
			<div class="mh-admin-widget">
				<?php
					echo $this->SimpleFilter->form();
					echo $this->SimpleFilter->options('Comment.approved', array('options' => $states, 'label' => __d('comments', 'Approved', true)));
					echo $this->SimpleFilter->end();
				?>
				
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>
