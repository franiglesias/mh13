<div class="mh-page">
	<div class="small-12 columns">
		<header>
			<h1><?php echo $this->Page->title(__d('school', 'Review your application', true)); ?></h1>
			<h2><?php __d('school', 'Check the status or resolution of your application'); ?></h2>
		</header>
	<div class="body">
		<!-- Content here -->
		<p>Puedes usar esta página para conocer el estado de tu solicitud de plaza y, en su caso, si has sido admitido o no.</p>
		<p>Para ello, introduce uno de los identificadores que has proporcionado al realizar la solicitud de plaza y que será el DNI del solicitante o de alguno de sus padres o tutores.</p>
		<p>Si introduces el DNI de un estudiante, se mostrará una única solicitud.</p>
		<p>Si proporcionas el DNI de uno de los padres o tutores, se mostrarán todas las solicitudes asociadas a ese DNI.</p>
		<div class="row">
		<?php
			echo $this->Form->create('Application', array(
				'url' => array('action' => 'review')
			));
			echo $this->FForm->input('Application.identifier', array(
				'label' => __d('school', 'ID Card', true),
				'div' => 'medium-4 columns'
			));
			echo $this->Form->submit(__d('school', 'Review your application', true), array(
				'div' => 'medium-4 columns end',
				'class' => 'button'
			));
			echo $this->Form->end();
		?>
		</div>
	</div></div>
</div>