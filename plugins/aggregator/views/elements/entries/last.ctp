<?php
/**
 * @param $planet string A planet slug or empty for all entries in aggregator
 */
	if (!isset($planet)) {
		$planet = false;
	} 
	$entries = $this->requestAction(
		array(
			'plugin' => 'aggregator',
			'controller' => 'entries',
			'action' => 'last'
		),
		array(
			'pass' => array($planet)
		)
	);
?>
<section id="mh-aggregator-last-entries" class="media widget">
	<header class="media-header widget-header">
		<h1 class="heading widget-heading"><?php __d('aggregator', 'Last aggregator entries'); ?></h1>
	</header>
	<div class="mh-legend">
		<p class="mh-new"><?php __d('aggregator', 'New entry'); ?></p>
		<p class="mh-updated"><?php __d('aggregator', 'Updated entry'); ?></p>
	</div>
	<div class="media-body entries">
	<?php foreach ($entries as $entry): ?>
		<?php 
			$entryUrl = array(
				'plugin' => 'aggregator',
				'controller' => 'entries',
				'action' => 'view',
				$entry['Entry']['id']
			);
			$entryUrl = $entry['Entry']['url'];
		
			$feedUrl = array(
				'plugin' => 'aggregator',
				'controller' => 'entries',
				'action' => 'feed',
				$entry['Feed']['slug']
			);

			$class = 'media entry';
			if ($entry['Entry']['status']) {
				$class .= ' mh-'.$entry['Entry']['status'];
			}	
		?>
	
		<article class="<?php echo $class; ?>"> 
			<div class="media-body entry-body">
			<header>
				<h1 class="heading entry-heading"><?php echo $this->Html->link($this->Article->title($entry['Entry']['title']), $entryUrl); ?></h1>
			</header>
			<?php echo $this->Article->excerpt($entry['Entry']['content'], array('size' => 150)); ?>
			</div>
			<footer class="media-footer entry-footer">
				<p><?php echo $this->Article->time($entry['Entry']['pubDate']); ?><?php __(' in '); ?> <?php echo $this->Html->link($entry['Feed']['title'], $feedUrl, array('class' => 'mh-button mh-channel-link')); ?></p>
			</footer>
		</article>
	<?php endforeach ?>
	</div>
	
	<p class="media-footer"><?php echo $this->Html->link(
		__d('aggregator', 'All aggregator entries', true),
		array(
			'plugin' => 'aggregator',
			'controller' => 'entries',
			'action' => 'index'
		),
		array('class' => 'mh-button mh-button-forward')
		) ?></p>
</section>