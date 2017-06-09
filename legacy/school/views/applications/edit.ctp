<?php 
App::import('Helper', 'presentation_model/TransitionBuilder');
$this->Application->bind($this->data); 
$Builder = new TransitionBuilder($this->Application);
?>
<div id="application-form">
<section id="applications-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Application', 'school', $this->Form->value('Application.student'));
				
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Application');?> 
		<fieldset>
			<legend><?php __d('school', 'Student data'); ?></legend>
			<div class="row">
				<?php
				echo $this->FForm->select('type', array(
					'label' => __d('school', 'Application type', true),
					'options' => $this->Application->types,
					'value' => $this->Form->value('type'),
					'readonly' => true,
					'div' => 'medium-3 columns'
				));
				echo $this->FForm->input('first_name', array(
					'div' => 'medium-4 columns',
					'label' => __d('school', 'First name', true),
					'help' => __d('school', 'First name', true),
					'error' => array(
						'notEmpty' => __d('school', 'Please, provide student name', true)
					)
				));
				echo $this->FForm->input('last_name', array(
					'div' => 'medium-4 columns end',
					'label' => __d('school', 'Last name', true),
					'help' => __d('school', 'Last name', true),
					'error' => array(
						'notEmpty' => __d('school', 'Please, provide student last name', true)
					)
				));
				?>
			</div>
			<div class="row">
			<?php
				echo $this->FForm->input('phone', array(
					'label' => __d('school', 'Phone', true),
					'div' => 'medium-4 columns',
					'help' => __d('school', 'We will use this telephone number to contact you for an interview.', true),
					'error' => array(
						'notEmpty' => __d('school', 'Please, provide a phone number for contact about your application', true)
					)
				));
				echo $this->FForm->email('email', array(
					'label' => __d('school', 'EMail for further contact', true),
					'help' => __d('school', 'We will use this email to several notifications.', true),
					'div' => 'medium-6 columns end',
					'error' => array(
						'email' => __d('school', 'Please, provide a valid email', true)
					)
				));
			?>
			</div>
			
		</fieldset>
		<dl class="tabs" data-tab data-options="deep_linking:true; scroll_to_content: false">
			<dd class="active"><a href="#tabs-1"><?php __d('school', 'Application data'); ?></a></dd>
			<dd><a href="#tabs-4"><?php __d('school', 'Contact data'); ?></a></dd>
			<dd><a href="#tabs-3"><?php __d('school', 'Identifier'); ?></a></dd>
			<dd><a href="#tabs-2"><?php __d('school', 'Application status'); ?></a></dd>
		</dl>
		<div class="tabs-content">
			<div class="content active" id="tabs-1">
				<fieldset>
					<legend><?php __d('school', 'Application Data'); ?></legend>
					<?php if ($this->data) echo $this->Form->input('id'); ?>
					<div class="row">
					<?php
					echo $this->FForm->pseudo($this->Application->format('created', 'relative'), array(
						'label' => __d('school', 'Date created', true),
						'div' => 'medium-3 columns'
					));
					echo $this->FForm->input('current', array(
						'label' => __d('school', 'Current studies', true),
						'div' => 'medium-4 columns'
					));
					echo $this->FForm->input('school', array(
						'label' => __d('school', 'Current school', true),
						'div' => 'medium-4 columns end'
					));
					echo $this->FForm->select('level_id', array(
						'label' => __d('school', 'Target level', true),
						'options' => $this->Application->levels,
						'help' => __d('school', 'Select the level you apply for', true),
						'div' => 'medium-3 columns'
					));
					echo $this->FForm->select('group', array(
						'label' => __d('school', 'Target section', true),
						'options' => $this->Application->sections,
						'empty' => true,
						'help' => __d('school', 'Select the group of you preference', true),
						'div' => 'medium-4 columns end'
					));
					?>
					</div>

				</fieldset>
			</div>
			<div class="content" id="tabs-2">
				<?php echo $this->XHtml->ajaxLoading('application-transitions') ?>
				<fieldset>
					<legend><?php __d('school', 'Application status'); ?></legend>
					<div class="row">
						<?php
						echo $this->FForm->select('status', array(
							'label' => __d('school', 'Status', true),
							'options' => $this->Application->statuses,
							'readonly' => true,
							'div' => 'medium-2 columns'
						));
						if ($this->Form->value('id')) {
							echo $Builder->render('status', 'medium-4 columns', '#tabs-2', '#application-transitions');
						}
						echo $this->FForm->date('interview', array(
							'label' => __d('school', 'Interview date', true),
							'clearable' => true,
							'div' => 'medium-3 columns'
						));
						echo $this->FForm->select('resolution', array(
							'label' => __d('school', 'Resolution', true),
							'options' => $this->Application->resolutions,
							'value' => $this->Form->value('resolution'),
							'readonly' => true,
							'div' => 'medium-3 columns end'
						));
						?>
					</div>
				</fieldset>
			</div>
			<div class="content" id="tabs-3">
				<fieldset>
					<legend><?php __d('school', 'Identifiers'); ?></legend>
					<div class="row">
					<?php
					echo $this->FForm->help(null, __d('school', 'You can use the ID cards to review the status of the application. PRovide at least on. All of them will be valid to access the application.', true));
					?>
					</div>
					<div class="row">
					<?php
						echo $this->FForm->input('idcard', array(
							'label' => __d('school', 'Student Id card', true),
							'help' => __d('school', 'A valid and unique Spanish DNI', true),
							'div' => 'medium-3 columns',
							'error' => array(
								'isDni' => __d('school', 'This is not a valid Spanish DNI', true),
								'atLeastOne' => __d('school', 'Provide at least one valid identifier to access the application', true),
								'isUnique' => __d('school', 'Only one application for student', true)
							)
						));
						echo $this->FForm->input('father_idcard', array(
							'label' => __d('school', 'Father Id card', true),
							'help' => __d('school', 'A valid Spanish DNI', true),
							'div' => 'medium-3 columns',
							'error' => array(
								'isDni' => __d('school', 'This is not a valid Spanish DNI', true),
								'atLeastOne' => __d('school', 'Provide at least one valid identifier to access the application', true)
								)

						));
						echo $this->FForm->input('mother_idcard', array(
							'label' => __d('school', 'Mother Id card', true),
							'help' => __d('school', 'A valid Spanish DNI', true),
							'div' => 'medium-3 columns end',
							'error' => array(
								'isDni' => __d('school', 'This is not a valid Spanish DNI', true),
								'atLeastOne' => __d('school', 'Provide at least one valid identifier to access the application', true)
								)

						));
					?>
					</div>
				</fieldset>
			</div>
			<div class="content" id="tabs-4">
				<fieldset>
					<legend><?php __d('school', 'Contact data'); ?></legend>
					<div class="row">
						<?php
						echo $this->FForm->input('parent', array(
							'label' => __d('school', 'Parent full name', true),
							'help' => __d('school', 'Please, provide the name of your father, mother or legal tutor for contact', true),
							'error' => array(
								'notEmpty' => __d('school', 'You must provide this data', true)
							)
						));

						echo $this->FForm->input('address', array(
							'label' => __d('school', 'Address', true),
							'help' => __d('school', 'We will use this address for written contact', true)
						));
						echo $this->FForm->input('address2', array(
							'label' => __d('school', 'Extra data for address', true),
							'help' => __d('school', 'If you need to provide more data for contact', true)
						));
						echo $this->FForm->input('cp', array(
							'label' => __d('school', 'Code', true),
							'help' => __d('school', 'Postal Code', true),
							'div' => 'medium-2 columns'
						));
						echo $this->FForm->input('city', array(
							'label' => __d('school', 'City', true),
							'help' => __d('school', 'Your city', true),
							'div' => 'medium-4 columns end'
						));

						
						?>
					</div>
				</fieldset>
			</div>
		</div>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
</div>