<?php echo $this->element('items/edit_scripts', array('plugin' => 'contents')); ?>
<section id="items-edit" class="mh-admin-panel">
	<header>
		<h1><?php printf(__('Create %s', true), __d('contents', 'Item', true)); ?></h1>
	</header>
	<div class="mh-admin-panel-body">
		<div id="output" class="mh-message"></div>
		<?php echo $this->Form->create('Item', array('type' => 'file'));?>
		<fieldset id="tabs-2">
			<legend><?php __d('contents', 'Select a channel to publish your item'); ?></legend>
			<?php
				echo $this->Form->input('channel_id', array(
					'label' => __d('contents', 'Channel', true),
					'after' => __d('contents', '<p>The channel to publish this piece.</p>', true)
					)
				);
			?>
		</fieldset>
		<?php echo $this->FForm->end(array(
			'saveAndWork' => false,
			'saveAndDone' => __d('contents', 'Create the new Article', true)
		)); ?>
	</div>
</section>
