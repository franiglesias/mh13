<header>
	<h1 class="fi-magnifying-glass"><?php __('Looking for something?'); ?></h1>
</header>

<div class="body">
<?php
	echo $this->Form->create(null, array(
		'url' => array('plugin' => 'contents', 'controller' => 'items', 'action' => 'search'),
		 'class' => 'mh-inline-form'
	));
	echo $this->FForm->input('Sindex.term', array('label' => __('Terms to find', true)));
	echo $this->Form->end(array('label' => __('Search', true), 'class' => 'mh-button mh-button-search'));
?> 
</div>