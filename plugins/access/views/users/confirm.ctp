<article class="mh-page">
	<header>
		<h1><?php __d('access', 'Your registration is now completed'); ?></h1>
	</header>
	<div class="body">
		<p><?php echo $html->link(__d('access', 'Go to main page', true), '/', array('class' => 'button left secondary radius')) ?> <?php echo $html->link(__d('access', 'Go to login page', true), array('action' => 'login'), array('class' => 'button right radius')); ?></p>
	</div>
</article>