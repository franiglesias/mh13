<?php echo $this->Page->title( __d('resumes', 'Job application forgotten credentials last step', true)); ?>
<header>
	<h1><?php __d('resumes', 'Recovering password'); ?></h1>
	<h2><?php __d('resumes', 'Only one step more, and you will be done'); ?></h2>
</header>
<div class="body">
	<p><?php __d('resumes', 'Please, check your email and visit the URL provided to renew your password.'); ?></p>
	<p><?php echo $html->link(__d('resumes', 'Go to main page', true), '/', array('class' => 'mh-btn-ok')) ?></p>
</div>
