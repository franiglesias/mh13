<?php $this->set('title_for_layout', __d('resumes', 'Job application Resume edition', true)); ?>
<?php
echo $this->Html->css('../js/jquery-te/jquery-te-1.4.0', null, array('inline' => false)); 
echo $this->Html->script('jquery-te/jquery-te-1.4.0.min', array('inline' => false)); 
echo $this->Html->script('jquery-te', array('inline' => false)); 

?>
	<header>
		<h1><?php __d('resumes', 'Edit your resume'); ?></h1>
	</header>
	<div class="body">
		<ul class="tabs" data-tab>
			<li class="tab-title"><a href="#tabs-2"><?php __d('resumes', 'Introduce yourself'); ?></a></li>
			<li class="tab-title"><a href="#tabs-1"><?php __d('resumes', 'Contact data'); ?></a></li>
		</ul>
		<?php echo $this->Form->create('Resume');?>
		<div class="tabs-content">
			<div class="content active" id="tabs-1">
			<fieldset>
				<legend><?php __d('resumes', 'Contact data'); ?></legend>
				<?php if ($this->data) {echo $this->Form->input('id');}	?>		
		
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
					echo $this->FForm->input('address', array(
						'div' => array('class' => 'small-12 columns'),
						'placeholder' => __d('resumes', 'Your complete address', true),
						'label' => __d('resumes', 'Address', true)
					));
					?>
				</div>
				<div class="row">
					<?php
					echo $this->FForm->input('address2', array(
						'div' => array('class' => 'small-12 columns'),
						'label' => __d('resumes', '2nd line address', true),
						'placeholder' => __d('resumes', 'Optional. If you need to include more data', true),
					));
			
					?>
				</div>
				<div class="row">
					<?php
					echo $this->FForm->input('cp', array(
						'div' => array('class' => 'small-2 columns'),
						'label' => __d('resumes', 'PC', true),
						'placeholder' => __d('resumes', 'Post Code', true)
					));
					echo $this->FForm->input('city', array(
						'div' => array('class' => 'small-6 columns'),
						'placeholder' => __d('resumes', 'Your City Name', true),
						'label' => __d('resumes', 'City', true)
					));
					echo $this->FForm->input('province', array(
						'div' => array('class' => 'small-4 columns'),
						'placeholder' => __d('resumes', 'Province', true),
						'label' => __d('resumes', 'Province', true)
					));
					?>
				</div>
				<div class="row">
					<?php 
					echo $this->FForm->input('phone', array(
						'label' => __d('resumes', 'Phone', true), 
						'div' => array('class' => 'small-3 columns'),
						'placeholder' => __d('resumes', 'Your contact phone', true)
						)); 
					echo $this->FForm->input('mobile', array(
						'label' => __d('resumes', 'Mobile', true), 
						'div' => array('class' => 'small-3 columns end'),
						'placeholder' => __d('resumes', 'Mobile or alternative phone', true)
						)); 
					?>
				</div>
				<div class="row">
					<?php
					echo $this->FForm->image('photo', array(
						'image' => $this->data['Resume']['photo'],
						'label' => __d('resumes', 'Photo', true),
						'help' => __d('resumes', 'Photograph with centered face (will be framed).', true)
						)
					);
					?>
				</div>
		
			</fieldset>
			</div>
			<div class="content" id="tabs-2">
			<fieldset>
				<legend><?php __d('resumes', 'Introduce yourself') ?></legend>
				<div class="row">
				<?php
				echo $this->FForm->select('position_id', array(
					'label' => __d('resumes', 'Position you apply for', true),
					'div' => array('class' => 'small-12 medium-6 columns'),
					'options' => $positions
				)); ?>
				</div>
				<div class="row">
					<?php echo $this->FForm->textarea('introduction', array(
						'type' => 'textarea', 
						'class' => 'editor', 
						'label' => __d('resumes', 'Introduction', true),
						'rows' => 15,
						'div' => array('class' => 'small-12 columns'),
					));
					?>
				</div>
			</fieldset>
			</div>
		</div>
		<?php echo $this->FForm->end(array(
			'saveAndWork' => false
		)); ?>
	</div>
