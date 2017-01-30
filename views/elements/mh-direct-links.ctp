<?php

$links = array(
	array(
		'image' => 'assets/estudiar_en_miralba.png',
		'label' => 'Estudiar en Miralba',
		'url' => array(
			'plugin' => 'contents', 'controller' => 'static_pages', 'action' => 'view', 'admisiones'
		)
	),
	array(
		'image' => 'assets/plataforma_familias.png',
		'label' => 'Plataforma Familias',
		'url' => 'https://www.jesuitinas.net/miralba/alumno/login.asp'
	),
	array(
		'image' => 'assets/club_deportivo.png',
		'label' => 'Club Deportivo',
		'url' => array(
			'plugin' => 'contents', 'controller' => 'channels', 'action' => 'view', 'cd_miralba'
		)
	),
	array(
		'image' => 'assets/hijas_de_jesus.png',
		'label' => 'Hijas de Jesús',
		'url' => 'http://www.jesuitinas.org'
	),
	array(
		'image' => 'assets/fasfi.png',
		'label' => 'FASFI',
		'url' => 'http://www.fasfi.org/'
	),
	array(
		'image' => 'assets/todo_contenido.png',
		'label' => 'Antiguos alumnos',
		'url' => array(
			'plugin' => 'contents', 'controller' => 'channels', 'action' => 'view', 'antiguos_alumnos'
		)
	),
);

?>
<div id="mh-direct-links">
<?php foreach ($links as $link) {
	$label = $this->Media->image($link['image'], array('size' => 'directLinksIcon'));
	$label .= $this->Html->tag('label', $link['label']);
	echo $this->Html->link($label, $link['url'], array('class' => 'item', 'escape' => false));
} ?>
</div>
