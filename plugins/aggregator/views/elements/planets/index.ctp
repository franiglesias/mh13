<?php
	if (!is_array($planet) || key($planet) != 'Planet') {
		$planet = array('Planet' => $planet);
	}
?>
<aside class="mh-widget">
<header>
	<h1 class="fi-web"><?php printf(__d('aggregator', 'Planet %s', true), $planet['Planet']['title']) ?></h1>
	<p><?php echo $planet['Planet']['description']; ?></p>
</header>
<?php if ($feeds): ?>
<div class="body">
	<ul class="mh-catalog-list">
	<?php foreach ($feeds as $afeed): ?>
	<li><?php echo $this->Html->link(
		$afeed['Feed']['title'], 
		array(
			'plugin' => 'aggregator',
			'controller' => 'entries',
			'action' => 'feed', 
			$afeed['Feed']['slug'])
		); ?></li>
	<?php endforeach ?>
	</ul>
</div>
<footer><?php echo $this->Html->link(__d('aggregator', 'See all planets', true), array('action' => 'index'), array('class' => 'mh-btn-index')); ?></footer>
<?php endif; ?>
</aside>