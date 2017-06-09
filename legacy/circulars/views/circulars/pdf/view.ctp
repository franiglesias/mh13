<?php
	// $this->Circular->bind($circularDTO);
	// debug($this->Circular->getDataSet());
	$this->Circular->link($this->Event, 'Event');
// Define page settings
	$pagina = array(
		'orientation' => 'L',
		'unit' => 'mm',
		'format' => 'A4'
		);
	$this->Pdf->setup($pagina);
    $this->Pdf->addPage();
// Load styles
	$this->element('/circulars/settings/styles', array('plugin' => 'circulars'));
// Metadata
	$this->Pdf->setMetaData(array(
		'author'   => 'Colegio Miralba',
		'creator'  => 'Milhojas CMS PDF Helper',
		'title'    => $this->Circular->mixValue('title'),
		'subject'  => 'Circulares Colegio Miralba',
		'keywords' => 'circular, '.$circular['CircularType']['title']
		)
	);
	$mx = $ox = 10;
	$languages = Configure::read('Config.languages');
	$currentSessionLanguage = $this->Session->read('Config.language');
	foreach ($languages as $language) {
		// Common heading
		$_SESSION['Config']['language'] = $language;
		$this->Circular->setLanguage($language);
		$this->Pdf->writeImageAt(7 + $mx - $ox,5, $assets.'membrete_a5_'.$language.'.jpg', 25);
		$this->Pdf->writeTextAt($mx+70, 5, 58, __d('circulars', 'city', true).', '. $this->Circular->format('pubDate', 'date'), 'fecha');
		$this->Pdf->writeTextAt($mx, 10, 128, $this->Circular->value('addressee'), 'destinatario');
		$this->Pdf->writeTextAt($mx, 20, 128, $this->Circular->value('title'), 'titulo');
		$this->Pdf->writeText(__d('circulars', 'gretting', true), 'cuerpo');
		$this->Pdf->writeText($this->Circular->value('content'), 'cuerpo');
		// Custom template
		$this->element('circulars/'.$circular['CircularType']['template'].'/pdf', array('plugin' => 'circulars', 'circular' => $circular, 'language' => $language));
		if ($this->Circular->value('extra')) {
			$this->Pdf->writeText(__d('circulars', 'reminders', true), 'subtitulo');
			$this->Pdf->writeText($this->Circular->value('extra'), 'cuerpo');
		}
		// Response box
		if ($this->Circular->value('circular_box_id')) {
			$pdf->dashLine($mx-$ox, 155, $mx - $ox + 148, 155, 3, 3, 0.25);
			$this->element('circulars/boxes/'.$circular['CircularBox']['template'], array(
				'circular' => $circular,
				'language' => $language,
				'plugin' => 'circulars',
				'mx' => $mx
			));
		}
		// Common footer
		$this->Pdf->writeText(__d('circulars', 'goodbye', true), 'cuerpo');
		$this->Pdf->writeText($this->Circular->value('signature'), 'cuerpo');
		$this->Pdf->writeTextAt($mx, 203 , 128, __d('circulars', 'footer', true), 'pie');
		$mx = $mx + 148;
		// Watermark
	}
	$_SESSION['Config']['language'] = $currentSessionLanguage;
	$this->Circular->setLanguage(null);
	$this->Pdf->save($this->Circular->value('filename'));
	if (!empty($show)) {
	    echo $this->Pdf->output($this->Circular->value('filename'), 'I');
		die();
	}
?>