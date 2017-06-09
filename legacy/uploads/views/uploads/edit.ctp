<section id="uploads-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'Upload', 'uploads', $this->Form->value('Upload.name'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Upload', array('type' => 'file', 'class' => 'media'));?>
		<div class="row">
			<div class="medium-4 columns">
				<?php $path = $this->Form->value('Upload.path'); ?>
				<?php if (!empty($path) && substr($path, 0, 3) === 'img'): ?>
					<div class="panel" id="mh-upload-image-preview">
						<?php echo $this->XHtml->ajaxLoading('combo-busy-indicator'); ?>
						<div id="upload-image-preview"><?php echo $this->Media->image($path, array('size' => 'uploadPreviewImage')) ?></div>
						<?php echo $this->FForm->rotateCombo(array('file' => $path, 'size' => 'uploadPreviewImage')); ?>
					</div>
				<?php else: ?>
					<div class="panel">
						<?php echo $this->Media->preview($this->Form->value('Upload.fullpath'), 'uploadPreviewImage'); ?>
					</div>
				<?php endif ?>
				
			</div>
			<div class="medium-8 columns">
				<fieldset>
					<legend><?php __d('uploads', 'File identification data'); ?></legend>
					<?php if ($this->data['Upload']['id']) {echo $this->Form->input('id');} ?>
					<div class="row">		
					<?php
						echo $this->FForm->input('name', array(
							'label' => __d('uploads', 'Name', true), 
							)
						);
						echo $this->FForm->textarea('description', array(
							'label' => __d('uploads', 'Description', true)
							)
						);
					?>
					</div>
				</fieldset>
				<fieldset>
					<legend><?php __d('uploads', 'Meta data'); ?></legend>
					<div class="row">
						<?php
						echo $this->FForm->input('size-alt', array(
							'label' => __d('uploads', 'Size', true), 
							'readonly' => true, 
							'div' => 'medium-3 columns', 
							'value' => $this->Number->toReadableSize($this->Form->value('size')),
							'class' => 'text-right',
							'icon' => 'arrow-down',
							'prefixSize' => 4
							)
						);
						
						echo $this->FForm->text('width', array(
							'label' => __d('uploads', 'Width', true),
							'readonly' => true, 
							'div' => 'medium-3 columns',
							'class' => 'text-right',
							'icon' => 'arrow-right',
							'prefixSize' => 4
							)
						);
						echo $this->FForm->text('height', array(
							'label' => __d('uploads', 'Height', true),
							'readonly' => true, 
							'div' => 'medium-3 columns',
							'class' => 'text-right',
							'icon' => 'arrow-up',
							'prefixSize' => 4
							)
						);
						echo $this->FForm->input('playtime-alt', array(
							'label' => __d('uploads', 'Play Time', true),
							'readonly' => true, 
							'class' => 'text-center',
							'div' => 'medium-3 columns', 
							'icon' => 'play-video',
							'prefixSize' => 4,
							'value' =>  $this->Upload->readablePlayTime($this->Form->value('playtime'))
							)
						);
						
						?>
					</div>
					<div class="row">
						<?php
						echo $this->FForm->input('type', array(
							'readonly' => true, 
							'div' => 'medium-5 columns', 
							'label' => __d('uploads', 'Type', true),
							'icon' => 'laptop',
							'prefixSize' => 2
							)
						);
						
						echo $this->FForm->input('path', array(
							'label' => __d('uploads', 'Relative path', true),
							'readonly' => true, 
							'icon' => 'foot',
							'prefixSize' => 2,
							'div' => 'medium-7 columns'
							)
						);
						?>
					</div>
					<div class="row">
						<?php
							echo $this->FForm->input('fullpath', array(
								'label' => __d('uploads', 'Full path', true),
								'readonly' => true, 
								'icon' => 'foot',
								'labelSize' => 1
								)
							);
						?>
					</div>
				</fieldset>
			</div>
		</div>
		<fieldset>
			<legend><?php __d('uploads', 'Relationships'); ?></legend>
			<div class="row">
				<?php
				echo $this->FForm->input('model', array(
					'label' => __d('uploads', 'Model', true),
					'div' => 'medium-3 columns',
					'readonly' => true
					));
				echo $this->FForm->input('foreign_key', array(
					'label' => __d('uploads', 'Key', true),
					'div' => 'medium-4 columns',
					'readonly' => true
					));
				echo $this->FForm->checkbox('enclosure', array(
					'label' => __d('uploads', 'Is enclosure', true),
					'div' => 'medium-2 columns end',
					'readonly' => true
					));
				?>
			</div>
			
			
			<label><?php __d('uploads', 'Physical files'); ?></label>
				<?php $count = 0; ?>
				<?php foreach ($related as $path): ?>
				<div class="row">
				<?php
					echo $this->FForm->input('related.'.$count, array(
						'readonly' => true,
						'value' => $path,
						'label' => false
					));
					$count++;
				?>
				</div>
				<?php endforeach ?>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>