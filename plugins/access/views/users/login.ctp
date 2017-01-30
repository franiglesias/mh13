<?php
	$supportedDomains = Configure::read('GApps.domain');
	$gappsLogin = false;
	$class ="small-block-grid-1";
	if ($available && $supportedDomains && $domain = implode(', ', $supportedDomains)) {
		$gappsLogin = true;
		$class .= " medium-block-grid-2";
	}
?>
<header>
	<h1><?php echo $this->Page->title(sprintf(__d('access', 'Login to %s', true), Configure::read('Site.title'))); ?></h1>
</header>

<div class="body">
	<ul class="<?php echo $class; ?>" data-equalizer>
		<li id="login-with-google-apps">
			<?php if ($gappsLogin): ?>
			<ul class="mh-pricing" data-equalizer-watch>
				<li class="title"><?php __d('access', 'Access with Google Apps'); ?></li>
				<li class="description"><?php printf(__dn('access', 'If you have an account in the following domain, use this method to login.', 'If you have an account in some of the following domains, use this method to login.',count($supportedDomains), true)); ?></li>
			<?php foreach ($supportedDomains as $domain): ?>
				<li class="bullet-item"><?php echo '@'.$domain; ?></li>
			<?php endforeach ?>
				<li class="description"><?php printf(__d('access', 'You will be redirected to log into your account, with your credentials for mail.', true)); ?></li>
				<li class="description"><?php __d('access', 'After that, you will be brought back to this site and automatically logged into your account.'); ?></li>
				<li class="cta-button">	<?php echo $this->Html->link(
					sprintf(__d('access', 'Login with your Google Apps account', true)),
					array('plugin' => 'access', 'controller' => 'users', 'action' => 'gauth'),
					array('class' => 'mh-btn-pricing')
					); ?></li>
			</ul>
			<?php endif ?>			
		</li>
		<li id="login-standard">
			<ul class="mh-pricing" data-equalizer-watch>
				<li class="title"><?php __d('access', 'Direct login'); ?></li>
				<li class="description"><?php __d('access', 'Login with the user and password created during registration or given to you by a site administrator.'); ?></li>
				<li class="cta-button">
					<a href="#" class="mh-btn-pricing" data-reveal-id="mh-login-form"><?php __d('access', 'Login with your credentials') ?></a>
				</li>
				
			</ul>
		</li>
	</ul>
</div>

<div id="mh-login-form" class="reveal-modal" data-reveal>
	<?php echo $this->Form->create('User', array('class' => 'frontend'));?>
	<fieldset>
	<legend><?php printf(__d('access', 'Login', true)); ?></legend>
		<div class="row">
		<?php echo $this->FForm->input('username', array(
			'label' => __d('access', 'User name', true),
			'icon' => 'torso',
			'labelPosition' => 'inline',
			'labelSize' => 2
		));
		?>
		</div>
		<div class="row">
		<?php echo $this->FForm->password('password', array(
			'label' => __d('access', 'Password', true),
			'labelPosition' => 'inline',
			'labelSize' => 2
		)); ?>
		</div>
	</fieldset>
	<?php echo $this->FForm->end(array(
		'returnTo' => array(
			'plugin' => 'access',
			'controller' => 'users',
			'action' => 'forgot'
			),
		'discard' => __d('access', 'Forgot password?', true),
		'saveAndWork' => false,
		'saveAndDone' => __d('access', 'Login', true)
	)); ?>
 	<a class="close-reveal-modal">&#215;</a>
</div>