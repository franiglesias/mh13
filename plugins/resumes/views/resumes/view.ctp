<?php
	$this->Page->title(sprintf(__d('resumes', 'Resume preview %s', true), $resume['Resume']['firstname'].' '.$resume['Resume']['lastname']));
?>
<div class="mh-admin-panel">
	<header>
		<h1><?php printf(__d('resumes', 'Showing %s\'s resume', true), $resume['Resume']['firstname'].' '.$resume['Resume']['lastname']); ?></h1>
	</header>
</div>

<?php echo $this->element('resume', array('plugin' => 'resumes', 'resume' => $resume)) ?>