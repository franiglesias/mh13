<article class="mh-page">
	<header>
		<h1><?php __d('access', 'Forgotted credentials'); ?></h1>
	</header>
	<div class="body">
		<p><?php __d('access', 'Please, provide your username and/or email so we can generate a new password for you.') ?></p>
		<p><?php __d('access', 'We will send you an email with a link to regenerate the password when you are ready. If, at the last moment, you decide that you don\'t want to renew the password, ignore the message. The link will expire in a few days.') ?></p>
		<p><?php __d('access', 'As last step, we will send the new provisional password to your email. Please, access to your profile and change the password as soon as posible.') ?></p>
	</div>
</article>

<div class="body">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php printf(__d('access', 'Identification data', true)); ?></legend>
		<div class="row">
			<?php
			echo $this->FForm->input('recovery_username', array(
				'label' => __d('access', 'Recovery Username', true),
				'help' => __d('access', '<p>Your account username.</p>', true),
			));
			echo $this->FForm->email('recovery_email', array(
				'label' => __d('access', 'Recovery Email', true),
				'help' => __d('access', '<p>The email associated with your account.</p>', true),
			));
			?>
		</div>
	</fieldset>
	<?php echo $this->FForm->end(array(
		'returnTo' => '/',
		'saveAndWork' => false,
		'discard' => __d('access', 'Forget about it', true),
		'saveAndDone' => __d('access', 'Try to recover my credentials', true)
	)); ?>
</div>
