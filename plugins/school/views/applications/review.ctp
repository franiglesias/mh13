<?php
	$private_options = array(
		'columns' => array(
			'type' => array(
				'label' => __d('school', 'Type', true),
				'type' => 'switch',
				'switch' => $this->Application->types
			),
			'student' => array(
				'label' => __d('school', 'Student', true),
				'attr' => array('class' => 'cell-long')
			),
			'modified' => array(
				'label' => __d('school', 'Application date', true),
				'type' => 'time',
				'format' => 'j/m/y'
			),
			'level_id' => array(
				'label' => __d('school', 'Target level', true),
				'type' => 'switch',
				'switch' => $this->Application->levels,
				'attr' => array('class' => 'cell-short')
			),
			'group' => array(
				'label' => __d('school', 'Target section', true),
				'type' => 'switch',
				'switch' => $this->Application->sections
			),
			'status' => array(
				'label' => __d('school', 'Application Status', true),
				'type' => 'switch',
				'switch' => $this->Application->statuses,
				'attr' => array('class' => 'cell-short')
			),
			'resolution' => array(
				'label' => __d('school', 'Resolution', true),
				'type' => 'switch',
				'switch' => $this->Application->resolutions,
				'attr' => array('class' => 'cell-short')
			)
			
		)
	);
	
	
	$public_options = array(
		'columns' => array(
			'type' => array(
				'label' => __d('school', 'Type', true),
				'type' => 'switch',
				'switch' => $this->Application->types
			),
			'student' => array(
				'label' => __d('school', 'Student', true),
				'attr' => array('class' => 'cell-long')
			),
			'modified' => array(
				'label' => __d('school', 'Application date', true),
				'type' => 'time',
				'format' => 'j/m/y'
			),
			'level_id' => array(
				'label' => __d('school', 'Target level', true),
				'type' => 'switch',
				'switch' => $this->Application->levels,
				'attr' => array('class' => 'cell-short')
			),
			'status' => array(
				'label' => __d('school', 'Application Status', true),
				'type' => 'switch',
				'switch' => $this->Application->statuses,
				'attr' => array('class' => 'cell-short')
			),
			'score' => array(
				'label' => __d('school', 'Score', true),
				'attr' => array('class' => 'cell-short cell-numeric')
			),

			'resolution' => array(
				'label' => __d('school', 'Resolution', true),
				'type' => 'switch',
				'switch' => $this->Application->resolutions,
				'attr' => array('class' => 'cell-short')
			)

		)
	);
	
?>
<div class="mh-page">
	<div class="small-12 columns">
		<header>
			<h1><?php echo $this->Page->title(__d('school', 'Review Applications', true)); ?></h1>
			<h2><?php printf(__d('school', 'For ID %s', true), $id); ?></h2>
		</header>
	<div class="body">
		<!-- Content here -->
		<?php if ($private_applications): ?>
			<h2><?php __d('school', 'Private levels applications'); ?></h2>
			<?php echo $this->Table->render($private_applications, $private_options); ?>
		<?php endif ?>
		<?php if ($public_applications): ?>
			<h2><?php __d('school', 'Public levels applications');	 ?></h2>
			<?php echo $this->Table->render($public_applications, $public_options); ?>
		<?php endif ?>
	</div>
	</div>
</div>