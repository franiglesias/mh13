<article class="mh-page">
	<div class="mh-page-header-container">
		<header class="mh-page-header">
			<h1 class="mh-page-title"><?php __('Playground'); ?></h1>
		</header>
	</div>
	<div class="mh-page-body">
		<?php echo $this->Form->create('Model'); ?>
		<fieldset>
			<legend>Sample form fields</legend>
			<div class="row">
			<?php echo $this->FForm->input('Model.textfield', array(
				'div' => array('class' => 'small-6 columns'),
				'label' => 'A text field, with postfix label',
				'postfix' => 'Take care'
			)); ?>
			<?php echo $this->FForm->input('Model.textfield2', array(
				'div' => array('class' => 'small-6 columns'),
				'label' => 'A text field, with prefix label',
				'prefix' => 'http'
			)); ?>
			
			</div>
			<div class="row">
				<?php echo $this->FForm->help(
				'Lo que viene aquí es un texto de ayuda para insertar en un formulario.',
				'Se trata de bloques de texto, se usarían en aquellas situaciones en las que necesitamos enriquecer el texto de ayuda de un formulario mediante instrucciones más detalladas'
				); ?>
			</div>
			<div class="row">
			<?php
				echo $this->FForm->date('Model.field', array(
					'div' => array('class' => 'small-4 columns'),
					'label' => 'A date field',
					'clearable' => true 
				));
			?>
			<?php
				echo $this->FForm->date('Model.fielddate', array(
					'div' => array('class' => 'small-4 columns'),
					'label' => 'A date field',
					'clearable' => false 
				));
			?>
			</div>
			<div class="row">
			<?php
				echo $this->FForm->image('Upload.uploader', array(
					'label' => 'Upload one image',
				));
			?>
			</div>
			<div class="row">
			<?php
				echo $this->FForm->images('Upload.uploader2', array(
					'label' => 'Upload images',
				));
			?>
			</div>
			
		</fieldset>
		<?php echo $this->Form->end('Ok'); ?>
	</div>
</article>
