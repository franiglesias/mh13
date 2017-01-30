<?php
	if (!isset($planet_id)) {$planet_id = null;}
?>
<aside class="mh-widget">
	<header>
		<h1 class="fi-target"><?php __d('aggregator', 'Missing a feed?'); ?></h1>
		<p><?php __d('aggregator', 'Recommend us new feeds to aggregate.'); ?></p>
	</header>
	<footer><?php echo $this->Html->link(__d('aggregator', 'Suggest a feed', true), array(
			'plugin' => 'aggregator',
			'controller' => 'feeds',
			'action' => 'suggest',
			$planet_id
			),
			array('class' => 'mh-btn-index')
		); ?>
	</footer>
</aside>