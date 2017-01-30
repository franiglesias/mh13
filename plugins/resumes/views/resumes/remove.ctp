<?php $this->Page->title(__d('resumes', 'Job application remove resume', true)); ?>
	<header>
		<h1><?php __d('resumes', 'Are you sure do you want to remove your Resume?'); ?></h1>
	</header>
	<div class="body">
		<h2>Una vez realizado el borrado no es posible recuperar esta información.</h2>
		<p>Una vez que borres tu currículum de nuestra base de datos será imposible recuperar esta información, aunque puede permanecer un máximo de 24 h. en las copias de seguridad automáticas que se realizan del contenido del servidor.</p>
		<p>Se eliminarán también tus datos de contacto.</p>
		<?php echo $this->Form->create('Resume');?>
		<fieldset>
			<legend><?php __d('resumes', 'Resume'); ?></legend>
			<div class="row">
				<?php
					echo $this->Form->input('id');
					echo $this->FForm->checkbox('delete', array(
						'label' => __d('resumes', 'Yes, remove my CV', true)
					));
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(array(
			'returnTo' => array('action' => 'home'),
			'saveAndWork' => false,
			'saveAndDone' => __d('resumes', 'I want to delete my resume', true),
			'discard' => __d('resumes', 'No, go back', true)
		)); ?>
	</div>
