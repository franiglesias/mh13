<div class="content active" id="tabs-contents">
	<fieldset>
		<legend><?php __d('contents', 'Item'); ?></legend>
		<div class="row">
			<?php
				echo $this->FForm->input('title', array(
					'label' => __d('contents', 'Title', true),
					'help' => __d('contents', 'Provide a descriptive title for this item.',true),
					'inputSize' => 12,
					'labelPosition' => 'standar'
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
					'inputSize' => 12,
					'labelPosition' => 'standar',
					'rows' => 15,
					'help' => __d('contents', 'The content of the item. Be careful with the style.', true).
						__d('contents', '<p>Insert YouTube: insert video url as http://www.youtube.com/watch?v=-asdfasfg</p>', true),
					));
			?>
		</div>
	</fieldset>
</div>