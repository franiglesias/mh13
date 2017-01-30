<?php
	$this->Event->setLanguage($language);
	$this->Pdf->writeText(__d('circulars', 'field trip data', true), 'subtitulo');
	$this->Pdf->writeText($this->Event->fieldtrip(), 'cuerpo2');
	$this->Pdf->writeText($this->Event->format('place', 'string', __d('circulars', 'Field trip place: %s', true)), 'cuerpo');
	if ($this->Event->value('description')) {
		$this->Pdf->writeText(__d('circulars', 'Field trip outline', true), 'subtitulo');
		$this->Pdf->writeText($this->Event->value('description'), 'cuerpo');
	}
	$this->Event->setLanguage();
?>
