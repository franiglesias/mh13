<?php $this->set('title_for_layout', sprintf(__d('resumes', 'Job application edit %s', true), $meritType['MeritType']['title'])); ?>
<div class="mh-page">
	<header>
		<h1><?php 
				echo $this->Backend->editHeading($this->data, 'Merit', 'resumes', $this->Form->value('Merit.title'));
			?></h1>		
	</header>
	<div class="body">
		<?php echo $this->Form->create('Merit', array('type' => 'file'));?>
		<fieldset>
			<legend><?php echo $this->Form->value('Merit.title'); ?></legend>
			<?php
				if (!empty($this->data['Merit']['id'])) {echo $this->Form->input('id');}
				echo $this->Form->input('merit_type_id', array(
					'type' => 'hidden'
				));
				echo $this->Form->input('resume_id', array(
					'type' => 'hidden'
				));
			?>
			<div class="row">
			<?php
				echo $this->FForm->input('title', array(
					'label' => $meritType['MeritType']['title_label'],
					'placeholder' => __d('resumes', 'Title', true)
				));
		
			?>
			</div>
			<div class="row">
			<?php
				echo $this->FForm->textarea('remarks', array(
					'label' => $meritType['MeritType']['remarks_label'],
					'placeholder' => __d('resumes', 'Any detail you consider important to tell us.', true)
				));
			?>
			</div>
			<?php if ($meritType['MeritType']['use_dates'] > 0): ?>
			<div class="row">
				<?php
					echo $this->FForm->input('start', array(
						'label' => $meritType['MeritType']['start_date_label'],
						'div' => 'small-3 columns',
						'placeholder' => __d('resumes', 'A year', true) 
					));
					if ($meritType['MeritType']['use_dates'] == 2) {
						echo $this->Form->input('end', array(
							'label' => $meritType['MeritType']['end_date_label'],
							'div' => 'small-3 columns end',
							'placeholder' => __d('resumes', 'A year', true) 
						));
					}
				?>
			</div>
			  	 
			<?php endif; ?>
			<?php if ($meritType['MeritType']['allow_file']): ?>
			<div class="row">
				<?php
					echo $this->FForm->file('file', array(
						'label' => $meritType['MeritType']['file_label'],
						'help' => __d('resumes', 'File size limited to 300 MB. Document format: we recommend PDF, others admitted. Video formats: mp4/H264. Image formats: png, jpg, gif.', true),
						'file' => $this->Form->value('Merit.file'),
						'mode' => 'inline'
					));
				?>
			</div>
			<?php endif; ?>
			<?php if ($meritType['MeritType']['allow_url']): ?>
			<div class="row">
				<?php
					echo $this->FForm->input('url', array(
						'label' => $meritType['MeritType']['url_label'],
						'placeholder' => __d('resumes', 'URL to an online resource relevant for this merit.', true),
					));
				?>
			</div>	  	 
			<?php endif; ?>
		</fieldset>
		<?php echo $this->FForm->end(array(
			
			'saveAndWork' => false
		)); ?>
	</div>
</div>
