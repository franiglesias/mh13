<?php

	if (!is_array($feed) || key($feed) != 'Feed') {
		$feed = array('Feed' => $feed);
	}
	
	if (!is_array($planet) || key($planet) != 'Planet') {
		$planet = array('Planet' => $planet);
	}

	$feedUrl = $this->Html->link(
		sprintf(__d('aggregator', 'Feed: %s', true), $feed['Feed']['title']),
		array(
			'plugin' => 'aggregator',
			'controller' => 'entries',
			'action' => 'feed',
			$feed['Feed']['slug'] 
			),
		array('class' => 'menu-item-link')	
		);
	
	$planetUrl = $this->Html->link(
		sprintf(__d('aggregator', 'Planet: %s', true), $planet['Planet']['title']),
		array(
			'plugin' => 'aggregator',
			'controller' => 'entries',
			'action' => 'planet',
			$planet['Planet']['slug'] 
			),
		array('class' => 'menu-item-link')
		);
	

?>
<aside class="mh-widget">
	<header class="media-header widget-header">
		<h1 class="heading widget-heading"><?php __d('aggregator', 'Links'); ?></h1>
	</header>
	<nav class="media-body widget-body">
		<ul class="menu">
			<li class="menu-item"><?php echo $feedUrl; ?></li>
			<li class="menu-item"><?php echo $planetUrl; ?></li>
		</ul>
	</nav>
</aside>