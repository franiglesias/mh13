<header>
	<h1><?php echo $this->Page->title(__d('resumes', 'Job application change password', true)); ?></h1>
</header>
<div class="body">
	<?php echo $this->Form->create('Resume');?>
	<fieldset>
		<legend><?php __d('resumes', 'Resume'); ?></legend>
	<?php 
	echo $this->Form->input('id');
	?>
	<div class="row">
		<?php
			echo $this->FForm->password('password', array(
				'label' => __d('resumes', 'Password', true),
				'placeholder' => __d('resumes', 'Your new password.', true)
			));
		?>
	</div>
	<div class="row">
		<?php
			echo $this->FForm->password('confirm_password', array(
				'label' => __d('resumes', 'Confirm Password', true),
				'placeholder' => __d('resumes', 'Retype your password.', true)
				
			));
		?>
	</div>
	</fieldset>
	<?php echo $this->FForm->end(array(
		'saveAndWork' => false
	)); ?>
</div>
