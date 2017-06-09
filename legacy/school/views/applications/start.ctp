<div class="mh-page">
	<div class="small-12 columns">
	<header>
		<h1><?php echo $this->Page->title('¿Quieres estudiar el Bachillerato con nosotros?'); ?></h1>
		<h2>Solicita tu plaza.</h2>
	</header>
	<div class="body">
		<!-- Content here -->
		<p>Solicita tu plaza desde el siguiente formulario y déjanos tus datos. Nosotros nos pondremos en contacto para concertar una entrevista y conocer el colegio.</p>
		<p>Una vez considerada tu solicitud, te comunicaremos si estás admitido/a o no. En caso afirmativo, podrás formalizar la reserva de la plaza mediante el anticipo de una mensualidad.</p>
		<p>El Bachillerato no está concertado en el colegio Miralba-Hijas de Jesús.</p>
		<p>Admitimos solicitudes para Bachillerato mientras dispongamos de plazas.</p>
		<p><?php echo $this->Html->link(
			__d('school', 'Apply', true),
			array(
				'plugin' => 'school',
				'controller' => 'applications',
				'action' => 'apply'
			),
			array('class' => 'mh-btn-ok right')
		); ?></p>
		<p><?php echo $this->Html->link(
			__d('school', 'Check your application', true),
			array(
				'plugin' => 'school',
				'controller' => 'applications',
				'action' => 'check'
			),
			array('class' => 'mh-btn-ok left')
		); ?></p>
	</div>
	</div>
</div>