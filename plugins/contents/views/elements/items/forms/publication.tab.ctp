<div class="content" id="tabs-publication">
	<fieldset>
		<legend><?php __d('contents', 'Publication'); ?></legend>
		<?php if (!empty($this->data['Item'])): ?>
		<div class="row">
			<?php
				$link = Router::url(array('plugin' => 'contents', 'controller' => 'items', 'action' => 'view', $this->Form->value('Item.slug')), true);
				echo $this->FForm->select('status', array(
					'label' => __d('contents', 'Status', true),
					'div' => 'medium-3 columns',
					'inputSize' => 4,
					'options' => array(
						0 => __d('contents', 'Draft', true),
						1 => __d('contents', 'Ready for Review', true),
						2 => __d('contents', 'Publish', true),
						3 => __d('contents', 'Expired', true)
						),
					'help' => sprintf(__d('contents', 'Set as Publish when ready to at <strong>%s</strong>.', true), $link)
					)
				);
				echo $this->FForm->date('pubDate', array(
					'div' => 'medium-12 columns',
					'inputSize' => 2,
					'readonly' => true,
					'clearable' => true,
					'label' => __d('contents', 'Publication Date', true),
					'help' => __d('contents', 'You can set dates in advance for future Publishing. Status must be set to \'Publish\'.', true),
					'icon' => 'calendar'
				));
				echo $this->FForm->date('expiration', array(
					'div' => 'medium-12 columns',
					'inputSize' => 2,
					'label' => __d('contents', 'Expiration date', true),
					'readonly' => true,
					'clearable' => true,
					'empty' => true,
					'icon' => 'calendar',
					'help' => __d('contents', 'Set a date if you want your post automatically removed from that date in advance.', true)
					)
				);
				echo $this->FForm->checkbox('search_if_expired', array(
					'label' => __d('contents', 'Search even expired', true),
					'div' => 'medium-3 columns',
					'help' => __d('contents', 'Include this items in searches even if expired. It will be marked accordingly.', true)
					)
				);
			?>
		</div>
		<div class="row">
			<?php
			if (!empty($contentsAdministrator)) {
				echo $this->FForm->checkbox('home', array(
					'label' => __d('contents', 'Publish at home page', true),
					'help' => __d('contents', 'Publish this item main home page.', true),
					'div' => 'medium-2 columns'
				));
			}

			echo $this->FForm->checkbox('featured', array(
				'label' => __d('contents', 'Feature?', true),
				'help' => __d('contents', 'If set, this item could get a special treatment in listings or selections of items.', true),
				'div' => 'medium-2 columns'
			));
			echo $this->FForm->checkbox('stick', array(
				'label' => __d('contents', 'Stick in the top of the channel home page?', true),
				'help' => __d('contents', 'If set, this item will appear at the top of listings.', true),
				'div' => 'medium-2 columns'
			));
			
			// echo $this->FForm->checkbox('live', array(
			// 	'div' => 'medium-2 columns end',
			// 	'label' => __d('contents', 'Make live?', true),
			// 	'help' => __d('contents', 'Items is set to live-blogging. Additions will be marked with a timestamp.', true)
			// 	)
			// );
			echo $this->FForm->select('allow_comments', array(
				'div' => 'medium-4 columns',
				'label' => __d('contents', 'Allow comments?', true),
				'options' => array(
					__d('contents', 'No comments', true),
					__d('contents', 'Comments closed', true),
					__d('contents', 'Moderated comments', true),
					__d('contents', 'Free comments', true)
					),
				'help' => __d('contents', 'Allow (or not) to post comments to this article.', true)
				)
			);
			
			
			?>
		</div>
		<div class="row">
			<?php
				echo $this->FForm->select('license_id', array(
					'label' => __d('contents', 'license', true),
					'help' => __d('contents', 'license lets you state how you allow others to use this material.', true),
					'options' => $licenses,
					'div' => 'medium-4 columns end'
					)
				);
			
			?>
		</div>
		<div class="row">
			<?php
				echo $this->FForm->textarea('remarks', array(
					'label' => __d('contents', 'Editor remarks', true),
					'help' => __d('contents', 'Editors may use this fielt to leave notes to authors aboute the article.', true)
					)
				);
			?>
		</div>
		<?php endif; ?>
	</fieldset>
</div>
