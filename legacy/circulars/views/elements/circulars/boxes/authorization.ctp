<?php

$tableDefinition = array(
	'columns' => array(
		'cabecera' => array(
			'width' => 48,
			'style' => 'header'
			),
		'contenido' => array(
			'width' => 80
			),
		'_style' => 'cuerpo'
		),
	'caption' => array(
		'text' => $this->Circular->format('title', 'string', __d('circulars', 'Authorization for %s', true)),
		'position' => 'top',
		'style' => 'subtitulo'
		),
	'table' => array(
		'width' => 128,
		'headers' => false,
		),
	'rows' => array(
		'_height' => 7
		)
	);

$data = array(
	array(
		'cabecera' => __d('circulars', 'treatment', true),
		'contenido' => ''
	),
	array(
		'cabecera' => __d('circulars', 'role', true),
		'contenido' => ''
	),
	array(
		'cabecera' => __d('circulars', 'authorization action', true),
		'contenido' => $this->Circular->value('title')
	),
	array(
		'cabecera' => __d('circulars', 'place, date and signature', true),
		'contenido' => ''
	)
);
	
	
$this->Pdf->writeTableAt($mx, 160, $data, $tableDefinition);

?>