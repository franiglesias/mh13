<?php
	$options = array(
		'columns' => array(
			'number' => array(
				'label' => __d('raffles', 'Number', true),
				'attr' => array('class' => 'cell-number cell-short')
			), 
			'title' => array(
				'label' => __d('raffles', 'Prize', true)
			), 
			'sponsor' => array(
				'label' => __d('raffles', 'Sponsor', true),
				'attr' => array('class' => 'cell-long')
			), 
		),
		'actions' => null,
		'table' => array('class' => 'admin-table')
		);
	$tableCode = $this->Table->render($prizes, $options);
?> 
<section id="prizes-index" class="mh-admin-panel">
	<header>
		<h1><?php __d('raffles', 'Official Prizes List');?></h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
				<?php echo $this->Html->link(
					__d('raffles', 'Manage Prizes', true), 
					array('action' => 'index'), 
					array('class' => 'mh-btn-index')
				); ?> 
				<?php echo $this->Html->link(
					__d('raffles', 'Print', true),
					array('action' => 'official', 'print' => true),
					array('class' => 'mh-btn-print', 'target' => '_blank')
				); ?>
				

			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>