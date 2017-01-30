<fieldset>
	<legend><?php __d('contents', 'Channel'); ?></legend>
	<div class="row">
	<?php
		echo $this->FForm->input('title', array(
			'label' => __d('contents', 'Title', true),
			'div' => 'medium-4 columns',
			'help' => __d('contents', 'An attractive and unique title for this Channel.', true)
			));
		echo $this->FForm->input('slug', array(
			'label' => __d('contents', 'Slug', true),
			'prefix' => Router::url(array('action' => 'view'), true).'/',
			'prefixSize' => 3,
			'inputSize' => 3,
			'div' => 'medium-4 columns end',
			'help' => __d('contents', 'A name for the URL of this channel', true)
		));
		echo $this->FForm->input('tagline', array(
			'label' => __d('contents', 'Tag line', true),
			'help' => __d('contents', 'A short sentence about your channel.', true),
			'div' => 'medium-8 columns end',
			'inputSize' => 12
		));
	?>
	</div>
	<div class="row">
	<?php
		echo $this->FForm->input('description', array(
			'label' => __d('contents', 'Description', true),
			'type' => 'textarea',
			'class' => 'ckeditor', 
			'inputSize' => 12,
			'rows' => 5,
			'help' => __d('contents', 'A brief description of the channel or a welcome message.', true)
			));
	?>
	</div>
	<div class="row">
		<?php
			echo $this->FForm->image('icon', array(
				'label' => __d('contents', 'Icon', true),
				'help' => __d('contents', 'An image for listings.', true),
				'div' => 'medium-6 columns end'
				));
			echo $this->FForm->image('image', array(
				'label' => __d('contents', 'Image', true),
				'help' => __d('contents', 'A nice image for channel home page.', true),
				'div' => 'medium-6 columns end'
				));
		?>
	</div>

</fieldset>