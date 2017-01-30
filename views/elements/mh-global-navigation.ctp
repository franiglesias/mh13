<!-- Menu bar in the top of the page and access link -->
<?php
	$title = Configure::read('Site.title');
	$title = false;
	$icon = Configure::read('Site.icon');
	if (!empty($icon)) {
		$icon = $this->Media->image($icon, array(
				'size' => 'menuIcon',
				'attr' => array('class' => 'mh-channel-menu-home-icon')
		));
		if (!empty($icon)) {
			$title = $icon.$title;
		}
	} 
?>
<nav id="mh-global-navigation" class="top-bar" data-topbar>
	<ul class="title-area">
		<li class="name">
			<h1><a href="<?php echo Router::url('/'); ?>"><?php echo $title; ?></a></h1>
		</li>
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menú</span></a></li>
	</ul>
	<section class="top-bar-section">
		<?php echo $this->Page->block('/menus/bar', array(
		'bar' => 'main', 
		'title' => false, 
		// 'id' => 'mh-secondary-navigation',
		'search' => true,
		'cache' => array(
			'time' => '+1 week',
			'key' => 'global'.$this->Session->read('Auth.User.id')
			)
		)); ?>
	<?php echo $this->Page->block('/access/status'); ?>
	</section>
</nav>