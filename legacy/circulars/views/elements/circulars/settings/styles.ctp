<?php

// Define styles
	$titulo = array(
		'line-height' => 5,
		'font-family' => 'Helvetica',
		'font-size' => 14,
		'font-style' => 'bold',
		'border' => 0,
		'after' => 5,
		'text-align' => 'center'
		);
	$subtitulo = array(
		'line-height' => 4,
		'font-family' => 'Helvetica',
		'font-size' => 10,
		'font-style' => 'bold',
		'border' => 'B',
		'after' => 1,
		'before' => 2,
		'text-align' => 'left'
		);
	$header = array(
		'extends' => 'cuerpo',
		'font-style' => 'bold',
		'background' => 220
	);
	$destinatario = array (
		'font-size' => 12,
		'extends' => 'titulo'
		);
	$cuerpo = array(
		'line-height' => 12 * PT,
		'font-size' => 8,
		'after' => 3
		);
	$cuerpo2 = array(
		'after' => 0,
		'extends' => 'cuerpo'
		);
	$pie = array(
		'font-size' => 7,
		'text-align' => 'center',
		'font-style' => 'bold',
		'extends' => 'cuerpo'
		);
	$fecha = array(
		'text-align' => 'right',
		'extends' => 'cuerpo'
		);
	$agua = array(
		'border' => 'BTLR',
		'line-height' => 10,
		'extends' => 'titulo',
		'background' => 230
		);
		
	// Register styles
		
	$this->Pdf->defineStyle('titulo', $titulo);
	$this->Pdf->defineStyle('subtitulo', $subtitulo);
	$this->Pdf->defineStyle('destinatario', $destinatario);
	$this->Pdf->defineStyle('cuerpo', $cuerpo);
	$this->Pdf->defineStyle('cuerpo2', $cuerpo2);
	$this->Pdf->defineStyle('header', $header);
	$this->Pdf->defineStyle('fecha', $fecha);
	$this->Pdf->defineStyle('pie', $pie);
	$this->Pdf->defineStyle('agua', $agua);

?>