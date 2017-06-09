<div class="content active" id="tabs-contents">
	<fieldset>
		<legend><?php __d('contents', 'Item'); ?></legend>
		<?php
			if ($this->Form->value('remarks')) {
				echo $this->Html->div('alert-box warning',
					$this->Html->tag('p', 
						$this->Html->tag('strong', __d('contents', 'Editor\'s note: ', true)).
						$this->Form->value('remarks')).
						$this->Html->link(
							'&times;',
							'#', 
							array('escape' => false, 'class' => 'close')
							),
					array('data-alert' => true)
					);
				}
		?>
		
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
					'help' => __d('contents', 'The content of the item. Be careful with the style.', true).
						__d('contents', '<p>Insert YouTube: insert video url as http://www.youtube.com/watch?v=-asdfasfg</p>', true),
					));
			?>
		</div>
	</fieldset>
</div>