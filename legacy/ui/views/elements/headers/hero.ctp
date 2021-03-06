<?php

$defaults = array(
	'image' => false,
	'icon' => false,
	'title' => false,
	'tagline' => false,
	'rss' => false,
	'imageOptions' => array(
		'size' => 'itemMainImage'
	),
	'url' => false,
	'parent' => false
);

extract($defaults, EXTR_SKIP);


?>

<div class="mh-header mh-header-full">
	<div class="mh-background-image">
		<?php echo $this->Media->image($image, $imageOptions); ?>
	</div>
	<div class="mh-header-overlay">
		<div class="icon"><a href="<?php echo Router::url($url);?>"><?php echo $this->Media->image($icon, array('size' => 'menuIcon')); ?> <?php echo $parent; ?></a></div>
		<div class="rss"></div>
		<h1><?php echo $title; ?></h1>
		<h2><?php echo $tagline; ?></h2>
	</div>
</div>