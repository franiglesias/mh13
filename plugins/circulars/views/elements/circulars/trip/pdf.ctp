<?php
	$this->Event->setLanguage($language);
	$this->Pdf->writeText(__d('circulars', 'Trip data', true), 'subtitulo');
	$this->Pdf->writeText($this->Event->format('place', 'string', __d('circulars', 'Trip place: %s', true)), 'cuerpo');
	$this->Pdf->writeText($this->Event->trip(), 'cuerpo2');
	if ($this->Event->value('description')) {
		$this->Pdf->writeText(__d('circulars', 'Trip outline', true), 'subtitulo');
		$this->Pdf->writeText($this->Event->value('description'), 'cuerpo');
	}
	$this->Event->setLanguage();
?>
