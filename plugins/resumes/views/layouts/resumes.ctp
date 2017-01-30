<?php

if ($this->Session->read('Resume.Auth.id')) {
	$menu = array();
	$menu[] = $this->Html->link(
		__d('resumes', 'Go to main page', true),
		array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'),
		array('class' => 'mh-btn-cancel'));
	$menu[] = $this->Html->link(
		__d('resumes', 'Preview your CV', true),
		array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'preview'),
		array('class' => 'mh-btn-view'));
	$menu[] = $this->Html->link(
		__d('resumes', 'Personal and contact data', true),
		array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'modify'),
		array('class' => 'mh-btn-person'));
	$menu[] = '<hr />';
	$menu[] = $this->Resume->typesMenu();
	$menu[] = '<hr />';
	$menu[] = $this->Html->link(
		__d('resumes', 'Change your password', true),
		array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'changepwd'),
		array('class' => 'mh-btn-key'));
	$menu[] = $this->Html->link(
		__d('resumes', 'Remove your CV', true),
		array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'remove'),
		array('class' => 'mh-btn-delete'));
	$menu[] = '<hr />';
	$menu[] = $this->Html->link(
		__d('resumes', 'Exit', true),
		array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'logout'),
		array('class' => 'mh-btn-cancel'));
	$menu = implode(chr(10), $menu);
	$code = <<<HTML
<div class="row">
	<div class="mh-page">
		<div class="medium-3 columns">
			<div class="mh-admin-widget">
				{$menu}
			</div>
		</div>
		<div class="medium-9 columns">
			{$content_for_layout}
		</div>
	</div>
</div>
HTML;

	 
} else {
	$code = <<<HTML
<div class="row">
	<div class="mh-page">
		<div class="small-12 column">
			{$content_for_layout}
		</div>
	</div>
</div>
HTML;

}
echo $this->renderLayout($code, 'basic');
?>

