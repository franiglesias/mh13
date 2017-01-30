<?php $this->Page->title(__d('resumes', 'Job application renew password', true)); ?>
	<header>
		<h1><?php __d('resumes', 'Your password has been renewed.'); ?></h1>
		<h2><?php __d('resumes', 'We have generated a new password for you and just send it to your email.'); ?></h2>
	</header>
	<div class="body">
		<p><?php __d('resumes', 'Please, check your email.'); ?></p>
		<p><?php echo $html->link(__d('resumes', 'Go to main page', true), array('action' => 'home'), array('class' => 'mh-btn-ok')) ?></p>
	</div>
