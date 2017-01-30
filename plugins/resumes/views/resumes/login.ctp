<?php $this->Page->title(__d('resumes', 'Job application login', true)); ?>
	<header>
		<h1><?php __d('resumes', 'Applicants login'); ?></h1>
		<h2><?php __d('resumes', 'Would you like to work with us?'); ?></h2>
	</header>
	<div class="body">
		<?php echo $this->Form->create('Resume');?>
		<fieldset>
			<legend><?php __d('resumes', 'Resume'); ?></legend>
			<div class="row">
				<?php
				echo $this->FForm->email('email', array(
					'label' => __d('resumes', 'Email', true),
					'div' => 'medium-6 columns end'
				));
				?>
			</div>
			<div class="row">
				<?php
				echo $this->FForm->password('password', array(
					'label' => __d('resumes', 'Password', true),
					'div' => 'medium-6 columns end'
				));
				?>
			</div>
			
		</fieldset>
		<?php echo $this->FForm->end(array(
			'returnTo' => array('action' => 'forgot'),
			'saveAndWork' => false,
			'saveAndDone' => __d('resumes', 'Login', true),
			'discard' => __d('resumes', 'Forgot your password?', true)
		)); ?>
	</div>
</div>