<section id="uploads-edit" class="mh-admin-panel">
	<header>
		<h1><?php 
			echo $this->Backend->editHeading($this->data, 'Upload', 'uploads', $this->Form->value('Upload.name'));
			?>
		</h1>
	</header>
	
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
				<fieldset class="media-body">
					<legend><?php __d('uploads', 'File identification data'); ?></legend>
					<?php if ($this->data) {echo $this->Form->input('id');} ?>
					<div class="row">
						<?php
							echo $this->FForm->input('name', array(
								'label' => __d('uploads', 'Name', true)
								)
							);
						?>
					</div>
					<div class="row">
						<?php
							echo $this->FForm->textarea('description', array(
								'label' => __d('uploads', 'Description', true)
								)
							);
						?>
					</div>
					<div class="row">
						<?php
							echo $this->FForm->input('url', array(
								'label' => __d('uploads', 'Link', true)
								)
							);
						?>
					</div>		
					
					<div class="row">
						<?php
							echo $this->FForm->number('order', array(
								'div' => 'medium-3 columns',
								'class' => 'input-short', 
								'label' => __d('uploads', 'order', true)
								)
							);
							echo $this->FForm->checkbox('enclosure', array(
								'div' => 'medium-2 columns end',
								'label' => __d('uploads', 'Enclosure', true)
								)
							);
						?>
					</div>		
				</fieldset>
			</div>
		</div>
	<?php
		echo $this->FForm->hidden(array('model', 'foreign_key'));
		// Prepare the submit button
		// This is the action we need to call to update the menu items list
		$url = array('plugin' => 'uploads', 'controller' => 'uploads', 'action' => 'index', $this->Form->value('Upload.model'), $this->Form->value('Upload.foreign_key'));
		echo $this->FForm->ajaxSend($url);
		echo $this->Form->end();
		echo $this->Js->writeBuffer();
	?>
</section>