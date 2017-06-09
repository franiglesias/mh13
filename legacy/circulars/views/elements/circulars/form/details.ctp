<div class="medium-6 columns">
	<fieldset>
		<legend><?php printf(__d('circulars', 'Details and signature (%s)', true), $languageName); ?></legend>
		
		<div class="row">
		<?php
			echo $this->FForm->translate('Circular.extra.'.$language, array(
				'sl' => $translate,
				'label' => __d('circulars', 'Extra content and remainders', true),
				'rows' => '5',
			));
			echo $this->FForm->translate('Circular.signature.'.$language, array(
				'sl' => $translate, 
				'label' => __d('circulars', 'Signature', true),
			));
		?>
		</div>
	</fieldset>
</div>
