<div class="content" id="tabs-taxonomy">
	<fieldset>
		<legend><?php __d('contents', 'Taxonomy'); ?></legend>
		<div class="row">
			<?php
				echo $this->FForm->select('channel_id', array(
					'label' => __d('contents', 'Channel', true),
					'div' => 'medium-4 columns',
					'help' => __d('contents', 'The channel to publish this piece.', true),
					'options' => $channels
					)
				);
				echo $this->FForm->select('level_id', array(
					'label' => __d('contents', 'Level', true),
					'div' => 'medium-3 columns end',
					'inputSize' => '3',
					'empty' => true,
					'help' => __d('contents', 'Level for this item if relevant.',true),
					'options' =>  $levels
				));
			?>
		</div>
		<div class="row">
			<?php
				echo $this->FForm->checkboxes('Label.Global', array(
					'label' => __d('contents', 'Global labels', true),
					'options' => $globalLabels,
					'multiple' => true,
					'inputSize' => 12,
					'div' => 'medium-6 columns',
					'value' => $this->data['Label']
				));				
				echo $this->FForm->checkboxes('Label.Model', array(
					'label' => __d('contents', 'Channel specific labels', true),
					'options' => $channelLabels,
					'multiple' => true,
					'div' => 'medium-6 columns',
					'inputSize' => 12,
					'value' => $this->data['Label']
				));				
				
			?>
		</div>
	</fieldset>
</div>
