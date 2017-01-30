<?php echo $this->element('items/edit_scripts', array('plugin' => 'contents')); ?>
<section id="staticPages-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'StaticPage', 'contents', $this->Form->value('StaticPage.title'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<div id="output" class="mh-message"></div>
		<?php echo $this->Form->create('StaticPage', array(
			'type' => 'file', 
			'class' => 'autosave',
			'mh-url' => Router::url(array('action' => 'autosave'))
		));?> 
		<?php echo $this->Form->input('App.lastTab', array('type' => 'hidden')); ?>
		<?php if ($this->data) echo $this->Form->input('id'); ?>
		
		<dl class="tabs" data-tab>
			<dd class="active"><a href="#tabs-1"><?php __d('contents', 'Contents'); ?></a></dd>
			<dd><a href="#tabs-2"><?php __d('contents', 'Upload Images and files'); ?></a></dd>
			<dd><a href="#tabs-3"><?php __d('contents', 'Related Pages'); ?></a></dd>
		</dl>
		
		<div class="tabs-content">
			<div class="content active" id="tabs-1">
				<fieldset>
					<legend><?php __d('contents', 'StaticPage Content'); ?></legend>
					<div class="row">
						<?php
							echo $this->FForm->input('title', array(
								'label' => __d('contents', 'Title', true),
								'help' => __d('contents', 'Provide a descriptive title for this item.',true)
								)
							);

						?>
					</div>
					<div class="row">
						<?php
							echo $this->FForm->textarea('content', array(
								'label' => __d('contents', 'Content', true),
								'type' => 'textarea', 
								'class' => 'ckeditor', 
								'rows' => 15,
								'help' => __d('contents', 'The content of the item. Be careful with the style.', true).'<br />'.
									__d('contents', 'Insert YouTube: insert video url as http://www.youtube.com/watch?v=-asdfasfg', true),
								));
						?>
					</div>
				</fieldset>
			</div>
			<div class="content" id="tabs-2">
				<fieldset>
					<legend><?php __d('contents', 'Images and files'); ?></legend>
					<div class="row">
						
						<?php
							echo $this->FForm->files('files', array(
								'div' => 'medium-7 columns',
								'label' => __d('contents', 'Files', true),
								'mode' => 'attach',
								'multiple' => true,
								'before' => __d('contents', '<p>Put here all related files. The first image will be used as the item main image.</p>', true),
								'update' => '#uploads-list',
								'url' => array(
									'plugin' => 'uploads',
									'controller' => 'uploads',
									'action' => 'owned',
									'StaticPage',
									$this->Form->value('id')
									)
								)
							);
							echo $this->FForm->select('gallery', array(
								'div' => 'medium-5 columns',
								'label' => __d('contents', 'How to show images', true),
								'options' => array(
									'lightbox' => __d('contents', 'Gallery with full photo view', true),
									'step' => __d('contents', 'Step by step explanations. Use title and description for images.', true),
									'bx' => __d('contents', 'Automatic sliding gallery.', true),
									'wall' => __d('contents', 'A very simple gallery', true)
								)
							));
						?>
					</div>
					<div class="panel radius clearfix">
						<div id="uploads-list">
							<?php
								echo $this->requestAction(
									array('plugin' => 'uploads', 'controller' => 'uploads', 'action' => 'owned'),
									array('return', 'pass' => array('StaticPage', $this->Form->value('StaticPage.id')))
								);

							?>
						</div>
					</div>

				</fieldset>
			</div>
			<div class="content" id="tabs-3">
				<fieldset>
					<legend><?php __d('contents', 'Related pages'); ?></legend>
					<div class="row">
						<?php
						echo $this->FForm->select('parent_id', array(
							'label' => __d('contents', 'Page descendant from', true),
							'options' => $staticParents, 
							'empty' => __d('contents','--This is a root or project main page--',true),
							'help' => __d('contents', 'Select a page from this one should descent. Leave empty to create a root or a project main page.', true),
							'div' => 'medium-6 columns',
							// 'mh-show-on-empty' => '#divStaticPageProjectKey',
							'mh-show-on-value' => '#divStaticPageOrder'
							)
						);
						echo $this->FForm->select('project_key', array(
							'label' => __d('contents', 'Project key', true),
							'help' => __d('contents', '<p>If this is the main page for a project, type the tag to retrieve all items related to it.</p>', true),
							'options' => $globalLabels,
							'empty' => __d('contents', '-- Select a label ---', true),
							'div' => 'medium-4 columns',
						));
						echo $this->FForm->number('order', array(
							'label' => __d('contents', 'Order', true),
							'help' => __d('contents', 'Position of this page in the listing', true),
							'div' => 'medium-2 columns'
						));
						
						?>
					</div>
				</fieldset>
			</div>		
		</div>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
<!-- Modal -->
<div id="upload-form" class="reveal-modal" data-reveal></div>