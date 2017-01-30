<div class="content" id="tabs-files">
	<fieldset>
		<legend><?php __d('contents', 'Images and files'); ?></legend>
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
						'Item',
						$this->Form->value('id')
						)
					)
				);
			?>
		</div>
		<div class="row">
			<?php
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
						array('return', 'pass' => array('Item', $this->Form->value('Item.id')))
					);

				?>
			</div>
		</div>
	</fieldset>
</div>
