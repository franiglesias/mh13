<?php
$this->FForm->defaults['labelPosition'] = 'inline';
$this->FForm->defaults['labelSize'] = 2;

?>
<article class="mh-page">
	<header>
		<h1><?php __d('access', 'Create a new account'); ?></h1>
	</header>
	<div class="body">
		<p><?php __d('access', 'Please, provide the following data in order to create an account to access this site.'); ?></p>
	</div>
</article>
<div class="body">
<?php echo $this->Form->create('User', array('class' => 'frontend'));?>
	<fieldset>
 		<legend><?php __d('access', 'Create your account'); ?></legend>
		<div class="row">
			<?php 
			echo $this->FForm->input('username', array(
				'label' => __d('access', 'User name', true), 
				'placeholder' => __d('access', 'A name for your account', true),
				'div' => 'medium-5 columns'
				));
			echo $this->FForm->input('realname', array(
				'label' => __d('access', 'Real name', true), 
				'placeholder' => __d('access', 'Your real full name or preferred nickname', true),
				'div' => 'medium-7 columns'
				)); ?>
			
		</div>
		<div class="row">
			<?php
			echo $this->FForm->password('confirm_password', array(
				'div' => 'medium-6 columns', 
				'label' => __d('access', 'Password', true),
				'placeholder' => __d('access', 'A password', true)
				));
			echo $this->FForm->password('password', array(
				'label' => __d('access', 'Confirm password', true), 
				'div' => 'medium-6 columns',
				'placeholder' => __d('access', 'Please, retype the password', true)
				));			
			?>
		</div>
		<div class="row">
			<?php
				echo $this->FForm->email('email', array(
					'label' => __d('access', 'Email', true), 
					'div' => 'medium-6 columns',
					'placeholder' => __d('access', 'An email for contact', true)
					));
				echo $this->FForm->email('confirm_email', array(
					'label' => __d('access', 'Confirm email', true), 
					'div' => 'medium-6 columns',
					'placeholder' => __d('access', 'Please, retype the email', true)
					));
			?>
		</div>
	</fieldset>
	<?php echo $this->FForm->end(array(
		'returnTo' => '/',
		'saveAndWork' => false,
		'discard' => false,
		'saveAndDone' => __d('access', 'Create my account, please!', true)
	)); ?>

</div>