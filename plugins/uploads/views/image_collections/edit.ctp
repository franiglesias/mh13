<section id="imageCollections-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'ImageCollection', 'uploads', $this->Form->value('ImageCollection.title'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<dl class="tabs" data-tab>
			<dd><a href="#tabs-1"><?php __d('uploads', 'Definition'); ?></a></dd>
			<dd><a href="#tabs-2"><?php __d('uploads', 'Upload Images and files'); ?></a></dd>
		</dl>
		<?php echo $this->Form->create('ImageCollection');?> 
		<div class="tabs-content">
			<div class="content active" id="tabs-1">
				<fieldset>
					<legend><?php __d('uploads', 'ImageCollection Definition'); ?></legend>
					<?php if ($this->data) echo $this->Form->input('id'); ?>
					<div class="row">
						<?php
						echo $this->FForm->input('title', array(
							'label' => __d('uploads', 'Title',  true),
							'div' => 'medium-4 columns'
						));
						echo $this->FForm->select('type', array(
							'label' => __d('uploads', 'Gallery type', true),
							'options' => array(
								'lightbox' => __d('contents', 'Gallery with full photo view', true),
								'step' => __d('contents', 'Step by step explanations. Use title and description for images.', true),
								'bx' => __d('contents', 'Automatic sliding gallery.', true),
								'wall' => __d('contents', 'A very simple gallery', true)
							),
							'div' => 'medium-3 columns'
						));
						
						echo $this->FForm->input('slug', array(
							'label' => __d('uploads', 'Slug', true),
							'readonly' => true,
							'div' => 'medium-5 columns'
						));
						
						?>
					</div>
					<div class="row">
					<?php
						echo $this->FForm->textarea('description', array(
							'label' => __d('uploads', 'Description', true)
						));
					?> 
					</div>
					
				</fieldset>
			</div>
			<div class="content" id="tabs-2">
				<fieldset id="tabs-2">
					<legend><?php __d('uploads', 'Upload images'); ?></legend>
					<div class="row">
						<?php
							echo $this->FForm->files('files', array(
								// 'div' => 'medium-7 columns',
								'label' => __d('contents', 'Files', true),
								'mode' => 'attach',
								'inputSize' => 12,
								'multiple' => true,
								'before' => __d('contents', '<p>Put here all related files. The first image will be used as the item main image.</p>', true),
								'update' => '#uploads-list',
								'url' => array(
									'plugin' => 'uploads',
									'controller' => 'uploads',
									'action' => 'owned',
									'ImageCollection',
									$this->Form->value('id')
									)
								)
							);
						?>
					</div>
					<div class="panel radius clearfix">
						<div id="uploads-list">
							<?php
								echo $this->requestAction(
									array('plugin' => 'uploads', 'controller' => 'uploads', 'action' => 'owned'),
									array('return', 'pass' => array('ImageCollection', $this->Form->value('ImageCollection.id')))
								);

							?>
						</div>
					</div>					
				</fieldset>
			</div>
		</div>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
<!-- Modal -->
<div id="upload-form" class="reveal-modal" data-reveal></div>