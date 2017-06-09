<div class="mh-page">
	<div class="small-12 columns">
		<header>
			<h1><?php echo $this->Page->title('Gracias por solicitar una plaza en Bachillerato en el colegio Miralba'); ?></h1>
			<h2>¿Qué pasa a continuación?</h2>
		</header>
		<div class="body">
			<!-- Content here -->
			<?php if ($Application): ?>
			<p>Gracias <?php echo $Application['Application']['first_name']; ?> por enviar tu solicitud.</p>
			<p>En breve recibirás un correo de confirmación en el email que has indicado.</p>
			<p>Dentro de poco nos pondremos en contacto contigo para concertar una entrevista, en la que podamos conocernos y visitar el centro.</p>
			<p>En ella te informaremos del resto de pasos para que puedas llegar a estudiar con nosotros tu Bachillerato.</p>
			<p>Hasta pronto.</p>
			<?php else: ?>
			<p>Ha habido algún problema.</p>	
			<?php endif ?>		
		</div>
	</div>
</div>