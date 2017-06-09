<?php

	$options = array(
		'columns' => array(
			'number' => array(
				'label' => __d('raffles', 'Number', true),
				'attr' => array('class' => 'cell-short cell-number')
			),
			'title' => array(
				'label' => __d('raffles', 'Prize', true),
				'attr' => array('class' => 'cell-long')
			),
			'sponsor' => array(
				'label' => __d('raffles', 'Sponsor', true),
				'attr' => array('class' => 'cell-long')
				
			)
		)
	);
	
?>
<div class="mh-page">
	<header>
		<h1><?php __d('raffles', 'Prizes list'); ?></h1>
	</header>
<div class="row medium-collapse">	
	<div class="medium-8 columns">
		<?php echo $this->Html->link(
			__d('raffles', 'Check your tickets', true),
			array(
				'plugin' => 'raffles',
				'controller' => 'prizes',
				'action' => 'check'
			),
			array('class' => 'mh-btn-index')
		); ?>
		<?php echo $this->Table->render($prizes, $options); ?>
	</div>
	<div class="medium-4 column">
		<?php echo $this->Page->block('/raffles/sponsors'); ?>
	</div>
	</div>
</div>