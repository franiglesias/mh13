<div class="medium-6 columns">
	<fieldset>
		<legend><?php echo $languageName; ?></legend>
		<div class="row">
		<?php
			echo $this->FForm->translate('Event.place.'.$language, array(
				'sl' => $translate,
				'label' => __d('circulars', 'Internal place', true),
			));
			echo $this->FForm->translate('Event.description.'.$language, array(
				'sl' => $translate,
				'label' => __d('circulars', 'Internal outline', true),
				'rows' => '5',
			));
		?>
		</div>
	</fieldset>
</div>
