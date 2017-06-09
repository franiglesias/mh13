<?php

$defaults = array(
	'image' => false,
	'icon' => false,
	'title' => false,
	'tagline' => false,
	'rss' => false,
	'url' => false,
	'parent' => false
);

extract($defaults, EXTR_SKIP);

?>

<div class="mh-header mh-header-simple">
	<div class="mh-header-overlay">
		<div class="icon"><?php echo $this->Media->image($icon, array('size' => 'headerLogo')); ?></div>
		<div class="rss"></div>
		<h1><?php echo $title; ?></h1>
		<h2><?php echo $tagline; ?></h2>
	</div>
</div>