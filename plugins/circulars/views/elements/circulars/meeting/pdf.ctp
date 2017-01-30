<?php
	$this->Event->setLanguage($language);
	$this->Pdf->writeText(__d('circulars', 'meeting data', true), 'subtitulo');
	$this->Pdf->writeText($this->Event->meeting(), 'cuerpo2');

	$this->Pdf->writeText($this->Event->format('place', 'string', __d('circulars', 'Meeting place: %s', true)), 'cuerpo');
	if ($this->Event->value('description')) {
		$this->Pdf->writeText(__d('circulars', 'meeting outline', true), 'subtitulo');
		$this->Pdf->writeText($this->Event->value('description'), 'cuerpo');
	}
	$this->Event->setLanguage();
?>
