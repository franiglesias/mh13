<?php 
// Deprecated
	$feeds = $this->requestAction(array(
		'plugin' => 'aggregator', 
		'controller' => 'feeds', 
		'action' => 'dashboard'
	));
	if ($feeds == 'disable') {
		return false;
	} 
?>
<div class="mh-dashboard-widget">
<header>
	<h1 class="fi-rss"><?php __d('aggregator', 'Aggregator Feeds waiting for approval'); ?>
		<span><?php printf(__d('aggregator', '# %s', true), count($feeds)); ?></span>
	</h1>
</header>

<div>
<?php if (empty($feeds)): ?>
	<?php echo $this->Page->block('/ui/nocontent', array(
		'message' => __d('aggregator', 'You don\'t have feeds waiting for approval', true)
	)); ?>
<?php else: ?>
	<ul class="mh-dashboard-list">
		<?php foreach ($feeds as $feed): ?>
		<li><?php echo $this->Html->link(
			$feed['Feed']['title'],
			array('plugin' => 'aggregator',
				'controller' => 'feeds',
				'action' => 'edit',
				$feed['Feed']['id']
			),
			array('escape' => false)
		); ?></li>
		<?php endforeach ?>
	</ul>
<?php endif; ?>
</div>
<footer>
	<p><?php echo $this->Html->link(
			__d('aggregator','Admin feeds', true),
			array('plugin' => 'aggregator', 'controller' => 'feeds', 'action' => 'index', !empty($feeds) ? 'waiting' : ''),
			array('class' => 'mh-dashboard-button')
		);
	?></p>
</footer>
</div>