<?php
$this->Page->title(sprintf(__d('resumes', 'Resume preview %s', true), $resume['Resume']['firstname'].' '.$resume['Resume']['lastname']));
?>
<?php echo $this->element('resume', array('plugin' => 'resumes', 'resume' => $resume)) ?>