<?php
if (empty($pageHeader)) {
	unset($pageHeader);
}
$defaults = array(
	'pageHeader' => array(
		'icon' => Configure::read('Site.icon'),
		'logo' => Configure::read('Site.logo'),
		'title' => Configure::read('Site.title'),
		'url' => '/',
		'tagline' => Configure::read('Site.tagline')
	),
	'size' => 'menuIcon'
);

extract($defaults, EXTR_SKIP);

$collection = $this->requestAction(
	array(
		'plugin' => 'uploads',
		'controller' => 'image_collections',
		'action' => 'collection',
	),
	array(
		'pass' => array(
			'home'
		)
	)
);

?>

<ul class="example-orbit-content" data-orbit data-options="
	animation:slide;
	pause_on_hover:false;
	animation_speed:250;
	navigation_arrows:false;
	timer_show_progress_bar: false;
	slide_number: false;
	next_on_click: true;
	bullets:false;">
	<?php foreach ($collection['Image'] as $image): ?>
	<li data-orbit-slide="<?php echo $image['name']; ?>">
		<div class="mh-page-title">
			<?php echo $this->Media->responsiveImage($image['path'], 'mainPageImage'); ?>
			<div id="mh-site-logo" class="mh-overlay">
				<?php echo $this->Media->responsiveImage($pageHeader['logo'], 'mainLogo'); ?>
			</div>
			<div class="mh-body">
				<h1><?php echo $image['name']; ?></h1>
				<p class="description"><?php echo $image['description']; ?></p>
				<?php if ($image['url']): ?>
				<p class="cta"><a href="<?php echo $image['url']; ?>" class="small info radius button fi-plus">Más información</a></p>
				<?php endif; ?>
			</div>
		</div>	
	</li>
	<?php endforeach ?>
</ul>

