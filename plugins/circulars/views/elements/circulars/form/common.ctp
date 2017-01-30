<div class="medium-6 columns">
	<fieldset>
		<legend><?php printf(__d('circulars', 'Title and introduction (%s)', true), $languageName); ?></legend>
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
		?>
		</div>
	</fieldset>
</div>
