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
					'options' => array(
						0 => __d('contents', 'Draft', true),
						1 => __d('contents', 'Ready for Review', true),
						),
					'help' => sprintf(__d('contents', 'Set as Publish when ready to at <strong>%s</strong>.', true), $link)
					)
				);
				echo $this->FForm->date('pubDate', array(
					'div' => 'medium-3 columns',
					'readonly' => true,
					'clearable' => true,
					'icon' => 'calendar',
					'label' => __d('contents', 'Publication Date', true),
					'help' => __d('contents', 'You can set dates in advance for future Publishing. Status must be set to \'Publish\'.', true)
				));
				echo $this->FForm->date('expiration', array(
					'div' => 'medium-3 columns',
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
				echo $this->FForm->select('license_id', array(
					'label' => __d('contents', 'license', true),
					'help' => __d('contents', 'license lets you state how you allow others to use this material.', true),
					'options' => $licenses,
					'div' => 'medium-4 columns end'
					)
				);
			
			?>
		</div>
		<?php endif; ?>
	</fieldset>
</div>
