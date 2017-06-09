<div class="mh-page">
	<div class="small-12 columns">
	<header>
		<h1><?php echo $this->Page->title(__d('school', 'Apply for our school', true)); ?></h1>
		<h2><?php __d('school', 'Fill in the data'); ?></h2>
	</header>
	<div class="body">
		
		<?php echo $this->Form->create('Application');?> 
			<fieldset>
			<legend><?php __d('school', 'Application data'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
				echo $this->FForm->input('first_name', array(
					'div' => 'medium-5 columns',
					'label' => __d('school', 'First name', true),
					'help' => __d('school', 'First name', true),
					'error' => array(
						'notEmpty' => __d('school', 'Please, provide student name', true)
					)
				));
				echo $this->FForm->input('last_name', array(
					'div' => 'medium-7 columns end',
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
			echo $this->FForm->input('current', array(
				'label' => __d('school', 'Current studies', true),
				'help' => __d('school', 'What are you studying currently?', true),
				'div' => 'medium-6 columns'
			));
			echo $this->FForm->input('school', array(
				'label' => __d('school', 'Your current school', true),
				'help' => __d('school', 'What school are you studying at?', true),
				'div' => 'medium-6 columns'
			));
			?>
			</div>
			<div class="row">
			<?php
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
			<fieldset>
				<legend><?php __d('school', 'Identifiers'); ?></legend>
				<div class="row">
				<?php
				echo $this->FForm->help(null, __d('school', 'You can use the ID cards to review the status of the application. Provide at least one. All of them will be valid to access the application.', true));
				?>
				</div>
				<div class="row">
				<?php
					echo $this->FForm->input('idcard', array(
						'label' => __d('school', 'Student Id card', true),
						'help' => __d('school', 'A valid and unique Spanish DNI', true),
						'div' => 'medium-4 columns',
						'error' => array(
							'isDni' => __d('school', 'This is not a valid Spanish DNI', true),
							'atLeastOne' => __d('school', 'Provide at least one valid identifier to access the application', true),
							'isUnique' => __d('school', 'Only one application for student', true)
						)
					));
					echo $this->FForm->input('father_idcard', array(
						'label' => __d('school', 'Father Id card', true),
						'help' => __d('school', 'A valid Spanish DNI', true),
						'div' => 'medium-4 columns',
						'error' => array(
							'isDni' => __d('school', 'This is not a valid Spanish DNI', true),
							'atLeastOne' => __d('school', 'Provide at least one valid identifier to access the application', true)
							)

					));
					echo $this->FForm->input('mother_idcard', array(
						'label' => __d('school', 'Mother Id card', true),
						'help' => __d('school', 'A valid Spanish DNI', true),
						'div' => 'medium-4 columns',
						'error' => array(
							'isDni' => __d('school', 'This is not a valid Spanish DNI', true),
							'atLeastOne' => __d('school', 'Provide at least one valid identifier to access the application', true)
							)

					));
				?>
				</div>
			</fieldset>
	<?php echo $this->FForm->end(array('discard' => false, 'saveAndWork' => false)); ?>    	
	</div>
	</div>
</div>
