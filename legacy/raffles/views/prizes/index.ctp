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
			'special' => array(
				'type' => 'boolean',
				'attr' => array('class' => 'cell-short'),
				'label' => __d('raffles', 'Special', true)
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
	$tableCode = $this->Table->render($prizes, $options);
?> 
<section id="prizes-index" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Admin %s', true), __d('raffles', 'Prizes', true));?>
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
					__d('raffles', 'Print Prizes list', true),
					array('action' => 'official', 'print' => true),
					array('class' => 'mh-btn-print', 'target' => '_bla	nk')
				);
				?>

			</div>
			<div class="mh-admin-widget">
				<?php
					echo $this->SimpleFilter->form();
					echo $this->SimpleFilter->contains('Prize.number', array(
						'label' => __d('raffles', 'Number', true)
					));
					echo $this->SimpleFilter->contains('Prize.title', array(
						'label' => __d('raffles', 'Prize', true)
					));
					echo $this->SimpleFilter->contains('Prize.sponsor', array(
						'label' => __d('raffles', 'Sponsor', true)
					));
					echo $this->SimpleFilter->end();
				?>
							
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $tableCode; ?>
		</div>
	</div>
</section>