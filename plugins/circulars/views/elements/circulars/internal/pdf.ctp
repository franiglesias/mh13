<?php
	$this->Event->setLanguage($language);
	$this->Pdf->writeText(__d('circulars', 'Internal activity data', true), 'subtitulo');
	$this->Pdf->writeText($this->Event->meeting(), 'cuerpo2');

	$this->Pdf->writeText($this->Event->format('place', 'string', __d('circulars', 'Activity place: %s', true)), 'cuerpo');
	if ($this->Event->value('description')) {
		$this->Pdf->writeText(__d('circulars', 'Activity outline', true), 'subtitulo');
		$this->Pdf->writeText($this->Event->value('description'), 'cuerpo');
	}
	$this->Event->setLanguage();
?>
