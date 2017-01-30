<article class="mh-page">
	<header>
		<h1><?php __d('access', 'Create a new account'); ?></h1>
	</header>
	<div class="body">
		<p><?php __d('access', 'Please, provide the following data in order to complete the account data.'); ?></p>
	</div>
</article>
<div class="body">
<?php echo $this->Form->create('User', array('inputDefaults' => array('class' => 'input-medium', 'div'=> array('class' => 'small-12 columns'))));?>
	<fieldset>
 		<legend><?php __d('access', 'Create your account'); ?></legend>
		<div class="row">
			<?php echo $this->FForm->input('username', array(
				'label' => __d('access', 'User name', true)
			)); 
			?>
		</div>
		<div class="row">
			<?php echo $this->FForm->email('email', array(
				'label' => __d('access', 'Email', true)
			)); 
			?>
		</div>
		<div class="row">
			<?php echo $this->FForm->input('realname', array(
				'label' => __d('access', 'Real name', true)
			)); ?>
		</div>
		<div class="row">
			<?php echo $this->FForm->textarea('bio', array(
				'label' => __d('access', 'Short Bio', true)
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
