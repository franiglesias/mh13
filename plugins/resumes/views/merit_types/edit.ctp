<section id="merit-types-edit" class="mh-admin-panel">
	<header>
		<h1><?php echo $this->Backend->editHeading($this->data, 'Merit Type', 'resumes', $this->Form->value('MeritType.title')); ?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('MeritType', array('type' => 'file'));?>
		<fieldset>
			<legend><?php __d('resumes', 'Edit Merit Categories'); ?></legend>
		<?php if ($this->data) {echo $this->Form->input('id');} ?>
		<div class="row">
			<?php
			echo $this->FForm->input('title', array(
				'label' => __d('resumes', 'Merit Category', true), 
				'div' => 'medium-6 columns',
				'help' => __d('resumes', 'A category to group facts in applicant\'s CV.', true)
			));
			echo $this->FForm->textarea('help', array(
				'label' => __d('resumes', 'Merit Help', true), 
				'div' => 'medium-6 columns',
				'help' => __d('resumes', 'A text to help our visitor to understand the kind of information they should provide here.', true)
			));
			?>
		</div>
		<div class="row">
			<?php
			echo $this->FForm->input('title_label', array(
				'label' => __d('resumes', 'Label for title', true), 
				'div' => 'medium-6 columns',
				'help' => __d('resumes', 'A label for the title field.', true)
			));
			echo $this->FForm->input('remarks_label', array(
				'label' => __d('resumes', 'Label for remarks', true), 
				'div' => 'medium-6 columns',
				'help' => __d('resumes', 'A label for the description field.', true)
			));
			?>
		</div>
		<div class="row">
			<?php
			echo $this->FForm->checkbox('ignore_dates', array(
				'label' => __d('resumes',  'Ignore dates', true),
				'help' => __d('resumes', 'Check this if dates are not needed to evaluate this merit.', true),
				'div' => 'medium-2 columns'
			));
			
			echo $this->Form->input('use_dates', array(
				'label' => __d('resumes', 'How to use dates', true),
				'options' => array(
					0 => __d('resumes', 'No dates', true),
					1 => __d('resumes', 'Unique date', true),
					2 => __d('resumes', 'Use both start and end dates', true)
					),
				'help' => __d('resumes', 'Select how to use dates for this merit type', true),
				'div' => 'medium-4 columns'
			));
			echo $this->FForm->input('start_date_label', array(
				'label' => __d('resumes', 'Label for start date', true), 
				'div' => 'medium-3 columns',
				'help' => __d('resumes', 'A label for the start date field.', true)
			));
			echo $this->FForm->input('end_date_label', array(
				'label' => __d('resumes', 'Label for end date', true), 
				'div' => 'medium-3 columns',
				'help' => __d('resumes', 'A label for the end date field.', true)
			));
			?>
		</div>
		<div class="row">
			<?php
			echo $this->FForm->checkbox('allow_url', array(
				'label' => __d('resumes', 'Allow URL', true),
				'help' => __d('resumes', 'Check if a URL is needed to provide evidence for this merit.', true),
				'div' => 'medium-2 columns'
			));
			echo $this->FForm->input('url_label', array(
				'label' => __d('resumes', 'Label for URL field', true),
				'help' => __d('resumes', 'A text label for the URL field.', true),
				'div' => 'medium-6 columns end'
			));
			?>
		</div>
		<div class="row">
			<?php
			echo $this->FForm->checkbox('allow_file', array(
				'label' => __d('resumes', 'Allow File', true),
				'help' => __d('resumes', 'Check if it is allowed to upload a file to provide evidence for this merit.', true),
				'div' => 'medium-2 columns'
			));
			echo $this->FForm->input('file_label', array(
				'label' => __d('resumes', 'Label for file field', true),
				'help' => __d('resumes', 'A text label for the file field.', true),
				'div' => 'medium-6 columns end'
			));
			?>
		</div>
		<div class="row">
			<?php
			echo $this->FForm->input('alias', array(
				'label' => __d('resumes', 'Merit alias', true), 
				'div' => 'medium-6 columns',
				'help' => __d('resumes', 'An alias for internal bindings. No special characters.', true)
				));
			
			?>
		</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>