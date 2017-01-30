<?php
$rssLink = array(
	'plugin' => 'aggregator',
	'controller' => 'entries',
	'action' => 'planet',
	$planet['Planet']['slug'],
	'ext' => 'rss'
	);
	
echo $this->Html->meta(
	__d('aggregator', 'Planet feed', true),
	$rssLink,
	array('type' => 'rss', 'inline' => false)
	);
	
$this->set(compact('feeds', 'planet'));
?>
<div class="mh-page">
	<div class="mh-page-header-container">
		<header>
			<h1><?php printf(__d('aggregator', 'Entries for planet %s', true), $planet['Planet']['title']);?></h1>
			<h2><?php echo $planet['Planet']['description']; ?></h2>
		</header>
	</div>
	<div class="mh-page-body">
	<?php if (!$entries): ?>
		 <?php __d('aggregator', 'There are no entries in this planet.'); ?>
	<?php else: ?>
		<?php foreach ($entries as $entry): ?>
			<?php echo $this->Aggregator->entry($entry, 'feed'); ?>
		<?php endforeach ?>
	</div>
	<?php endif; ?>
</div>
<footer>
	<?php echo $this->Page->paginator('mh-public-paginator'); ?>
</footer>

