<?php
	echo $this->FForm->select('Channel.layout', array(
		'label' => __d('contents', 'Layout', true),
		'options' => $layouts,
		'empty' => __d('contents', '-- Select a layout --', true),
		'help' => __d('contents', 'Layout for Channel\'s main page.', true),
		'div' => false,
		'indicator' => true,
		// 'before' => $this->XHtml->ajaxLoading()
		));

?>