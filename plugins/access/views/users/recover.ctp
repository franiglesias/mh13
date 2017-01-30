<article class="mh-page">
	<header>
		<h1><?php __d('access', 'Your password has been renewed.'); ?></h1>
		<h2><?php __d('access', 'We have generated a new password for you and just send it to your email.'); ?></h2>
	</header>
	<div class="body">
		<p><?php __d('access', 'Please, check your email.'); ?></p>
		<p><?php echo $html->link(__d('access', 'Go to main page', true), '/', array('class' => 'mh-btn-index')) ?></p>
	</div>
</article>