<?php $this->Page->title(__d('resumes', 'Job application forgotted credentials', true)); ?>
<header>
	<h1><?php __d('resumes', 'Forgotted credentials'); ?></h1>
</header>
<div class="body">
	<p><?php __d('resumes', 'Please, provide your email so we can generate a new password for you.') ?></p>
	<p><?php __d('resumes', 'We will send you an email with a link to regenerate the password when you are ready. If, at the last moment, you decide that you don\'t want to renew the password, ignore the message. The link will expire in a few days.') ?></p>
	<p><?php __d('resumes', 'As last step, we will send the new provisional password to your email. Please, access to your profile and change the password as soon as posible.') ?></p>

	<?php echo $this->Form->create('Resume', array('class' => 'frontend'));?>
	<fieldset>
 		<legend><?php printf(__d('resumes', 'Identification data', true)); ?></legend>
		<div class="row">
			<?php
				echo $this->FForm->email('recovery_email', array(
					'label' => __d('resumes', 'Recovery Email', true),
					'help' => __d('resumes', 'The email associated with your resume.', true),
					)
				);
			?>
		</div>
	</fieldset>
	<?php echo $this->FForm->end(array(
		'returnTo' => array('action' => 'home'),
		'saveAndWork' => false,
		'discard' => __d('resumes', 'No, thanks', true),
		'saveAndDone' => __d('resumes', 'Help me to recover my password', true)
	)); ?>
</div>
