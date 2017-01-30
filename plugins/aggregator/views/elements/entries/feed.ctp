<?php
/**
 * @param $planet string A planet slug or empty for all entries in aggregator
 */
	if (!isset($feed)) {
		$feed = false;
	} 
	$entries = $this->requestAction(array(
		'plugin' => 'aggregator',
		'controller' => 'entries',
		'action' => 'feed'
		),
		array(
			'pass' => array($feed)
			)
	);
?>
<aside class="mh-widget">
<header>
	<h1><?php __d('aggregator', 'Last entries'); ?></h1>
</header>

<div class="body">
	<?php foreach ($entries as $entry): ?>
	<?php 
		$entryUrl = array(
			'plugin' => 'aggregator',
			'controller' => 'entries',
			'action' => 'view',
			$entry['Entry']['id']
		);
	
		$class = "media";
		if ($entry['Entry']['status']) {
			$class .= $entry['Entry']['status'];
		}
	?>
	<article class="<?php echo $class; ?>">	 
		<header class="media-header">
			<h1 class="heading entry-heading"><?php echo $this->Html->link($this->Article->title($entry['Entry']['title']), $entryUrl); ?></h1>
		</header>
		<footer class="media-footer">
			<p><?php echo $this->Article->time($entry['Entry']['pubDate']); ?></p>
		</footer>
	</article>
	<?php endforeach ?>
</div>
</aside>