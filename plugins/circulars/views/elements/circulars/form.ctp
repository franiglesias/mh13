<div class="medium-6 columns">
	<fieldset>
		<legend><?php echo $languageName; ?></legend>
		<div class="row">
		<?php
			echo $this->FForm->translate('Circular.title.'.$language, array(
				'sl' => $translate, 
				'label' => __d('circulars', 'Title', true),
				'error' => array(
					'notEmpty' => __d('circulars', 'Circular needs a title', true)
				)
				));
			echo $this->FForm->translate('Circular.content.'.$language, array(
				'sl' => $translate,
				'label' => __d('circulars', 'Content', true),
				'rows' => '5',
			));
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
