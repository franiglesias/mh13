<header>
	<h1><?php echo $this->Page->title(__d('resumes', 'Create a job application', true)); ?></h1>
</header>
<div class="body clearfix">
	<p>En este formulario crearás una cuenta de acceso en la que tu email será tu identificación.</p>
	<p>Procura no utilizar contraseñas iguales a las que utilizas en otros servicios.</p>
	<p>En una siguiente fase podrás incluir tus cualificaciones, formación, experiencia, habilitaciones, etc.</p>
	<p>En cualquier momento podrás acceder a tu currículum para modificarlo, cambiar tus datos de contacto o eliminarlo de nuestra base de datos.</p>
	<p>La información que nos proporcionas aquí se utilizará únicamente en relación con posibles vacantes laborales en el colegio. No compartimos esta información con ninguna otra empresa u organización.</p>

<?php echo $this->Form->create('Resume', array('class' => 'frontend', 'inputDefaults' => array('class' => 'input-medium')));?>
	<fieldset>
 		<legend><?php __d('resumes', 'Create your account'); ?></legend>
		<?php
			if ($this->data) {
				echo $this->Form->input('id');
			}
		?>
		<div class="row">
			<?php
				echo $this->FForm->email('email', array(
					'label' => __d('resumes', 'Email', true), 
					'div' => array('class' => 'small-12 medium-6 columns'),
					'placeholder' => __d('resumes', 'An email for contact', true)
					));
				echo $this->FForm->email('confirm_email', array(
					'label' => __d('resumes', 'Confirm email', true), 
					'div' => array('class' => 'small-12 medium-6 columns'),
					'placeholder' => __d('resumes', 'Please, retype the email', true)
					));
			?>
		</div>
		<div class="row">
			<?php
			echo $this->FForm->input('confirm_password', array(
				'type' => 'password', 
				'div' => array('class' => 'small-12 medium-6 columns'), 
				'label' => __d('resumes', 'Password', true),
				'placeholder' => __d('resumes', 'A password', true)
				));
			echo $this->FForm->input('password', array(
				'type' => 'password', 
				'label' => __d('resumes', 'Confirm password', true), 
				'div' => array('class' => 'small-12 medium-6 columns'),
				'placeholder' => __d('resumes', 'Please, retype the password', true)
				));			
			?>
		</div>
		<div class="row">
			<?php 
			echo $this->FForm->input('firstname', array(
				'label' => __d('resumes', 'First name', true), 
				'div' => array('class' => 'small-5 columns'),
				'placeholder' => __d('resumes', 'Your first name', true)
				)); 
			echo $this->FForm->input('lastname', array(
				'label' => __d('resumes', 'Last name', true), 
				'div' => array('class' => 'small-7 columns'),
				'placeholder' => __d('resumes', 'Your Last name', true)
				)); 
			?>
		</div>
		<div class="row">
			<?php 
			echo $this->FForm->input('phone', array(
				'label' => __d('resumes', 'Phone', true), 
				'div' => array('class' => 'small-6 columns'),
				'placeholder' => __d('resumes', 'Your contact phone', true)
				)); 
			echo $this->FForm->input('mobile', array(
				'label' => __d('resumes', 'Mobile', true), 
				'div' => array('class' => 'small-6 columns'),
				'placeholder' => __d('resumes', 'Mobile or alternative phone', true)
				)); 
			?>
		</div>
	</fieldset>
	<?php echo $this->FForm->end(array(
		'saveAndWork' => false,
		'saveAndDone' => __d('resumes', 'Create my resume, please!', true)
	)); ?>
</div>
