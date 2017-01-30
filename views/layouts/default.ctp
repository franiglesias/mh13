<?php
	$options = array(compact('pageHeader'));
	$options['cache'] = array('time' => '+7 days', 'key' => 'home_page_carrousel');
	
	$page = $this->Page->block('mh-page-title', $options);
	$page .= $this->Page->block('mh-direct-links', array(
		'cache' => array('time' => '+30 days', 'key' => 'mh-direct-links')
	));
	$page .= $this->Html->tag('div', $content_for_layout,array('class' => ''));

	echo $this->renderLayout($page, 'basic');
?>
