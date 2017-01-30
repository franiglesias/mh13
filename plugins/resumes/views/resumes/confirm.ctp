<?php $this->Page->title(__d('resumes', 'Job application terms acceptance', true)); ?>
<header>
	<h1><?php __('Terms and conditions'); ?></h1>
	<h2><?php __('Please, read the following terms and conditions.') ?></h2>
</header>
<div class="body">
	<h2>Carácter propio del centro</h2>
	<p>El Colegio Miralba-Hijas de Jesús es un colegio religioso cristiano, concertado y plurilingüe, perteneciente a la Congregación de las Hijas de Jesús. Nuestra oferta educativa abarca desde los 3 años de edad hasta el Bachillerato.</p>
	<p><a href="http://miralba.org/static/bienvenida">Más información</a></p>
	<h2>Privacidad</h2>
	<p>Los datos del registro de tu currículum se almacenan en un fichero informático propiedad del Colegio Miralba, y serán utilizados únicamente en relación a posibles oportunidades laborales en el colegio.</p>
	<p>Puedes usar esta misma página web para ejercer tus derechos de rectificación, cancelación y oposición. En caso de dudas o problemas puedes ponerte en <a href="mailto:webmaster@miralba.org">contacto con nosotros</a></p>
	<h2>Aceptación</h2>
	<p>Al hacer clic en Aceptar y registrar tu currículum aceptas los términos expuestos.</p>
	<?php
		echo $this->Html->link (__('Cancel', true), $cancelUrl, array('class' => 'button left radius'));
		echo $this->Html->link (__('Accept', true), $acceptUrl, array('class' => 'button right radius secondary'));
	?>
</div>
