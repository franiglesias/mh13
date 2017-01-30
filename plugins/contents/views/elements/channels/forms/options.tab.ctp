<fieldset>
	<legend><?php __d('contents', 'Options'); ?></legend>
	<div class="row">
	<?php
		echo $this->FForm->division(__d('contents', 'Publishing options', true), array());
		echo $this->FForm->help('small-12 columns', 
		__d('contents', 'Check active to allow your channel to be visible in the web.', true)
		);
		echo $this->FForm->checkbox('active', array(
			'label' => __d('contents', 'Active', true),
			'help' => __d('contents', 'Check to get your Channel Online.', true),
			'div' => 'medium-2 columns'
			));
		echo $this->FForm->help('small-12 columns', 
		__d('contents', 'Check external if your channel is of general public interest. Leave unchecked if the channel is for internal compsumption.', true)
		);

		echo $this->FForm->checkbox('external', array(
			'label' => __d('contents', 'External', true),
			'help' => __d('contents', 'External channels are those suited for general public.', true),
			'div' => 'medium-2 columns'
			));
		echo $this->FForm->checkboxes('Site', array(
			'options' => $sites,
			'inputSize' => 12,
			'label' => __d('contents', 'Aggregate this channel to the following sites', true),
		));
	?>
	</div>
	<div class="row">
	<?php
		echo $this->FForm->division(__d('contents', 'Design options', true), array());
		$url = Router::url(array('action' => 'layouts'));
		echo $this->FForm->select('Channel.theme', array(
			'label' => __d('contents', 'Theme', true),
			'options' => $themes,
			'empty' => __d('contents', 'Default theme', true),
			'help' => __d('contents', 'Appearance theme.', true),
			'div' => 'medium-4 columns',
			'class' => 'mh-parent-select',
			'mh-url' => $url,
			'mh-update' => '#divChannelLayout',
			'mh-indicator' => '#divChannelLayout-busy'
			));
		echo $this->FForm->select('Channel.layout', array(
			'label' => __d('contents', 'Layout', true),
			'options' => $layouts,
			'empty' => __d('contents', '-- Select a layout --', true),
			'help' => __d('contents', 'Layout for Channel\'s main page.', true),
			'div' => array('class' => 'medium-4 columns'),
			'indicator' => true,
			));
		echo $this->FForm->select('menu_id', array(
			'help' => __d('contents', 'Main menu for the channel.', true),
			'empty' => true,
			'options' => $menus,
			'div' => 'medium-4 columns',
			'label' => __d('contents', 'Associate a menu to this channel', true)
			)
		);
	?>
	</div>
	<div class="row">
	<?php
	echo $this->FForm->division(__d('contents', 'Channel Policies', true), array());
	echo $this->FForm->input('allow_comments', array(
		'options' => array(
			__d('contents', 'No comments', true),
			__d('contents', 'Comments closed', true),
			__d('contents', 'Moderated comments', true),
			__d('contents', 'Free comments', true)
			),
		'help' => __d('contents', 'Default status for comments.', true),
		'div' => 'medium-4 columns',
		'label' => __d('contents', 'Default Comments policy', true)
		));
	echo $this->FForm->select('license_id', array(
		'help' => __d('contents', 'Default license type for the contents of the Channel. Authors can set their own on item basis.', true),
		'div' => 'medium-4 columns',
		'options' => $licenses,
		'label' => __d('contents', 'License', true)
		));
	
	?>
	</div>
	
</fieldset>