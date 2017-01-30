<?php
	if (is_array($planet) && key($planet) != 'Planet') {
		$planet = array('Planet' => $planet);
	}
?>
<aside class="mh-widget">
	<header>
		<h1 class="fi-link"><?php __d('aggregator', 'Links'); ?></h1>
	</header>
	<nav class="body">
		<ul class="mh-catalog-list">
			<li><?php echo $this->Html->link(__d('aggregator', 'Aggregator Home', true), array('action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(
				sprintf(__d('aggregator', 'Planet: %s', true),  $planet['Planet']['title']),
				array(
					'plugin' => 'aggregator',
					'controller' => 'entries',
					'action' => 'planet',
					$planet['Planet']['slug']
					)
				); ?></li>
			<li><?php echo $this->Html->link(
				__d('aggregator', 'Feed Home page', true),
				$feed['Feed']['url']
				); ?></li>
		</ul>
	</nav>
</aside>