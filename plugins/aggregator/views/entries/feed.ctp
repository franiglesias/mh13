<?php $this->set(compact('feed', 'feeds')); ?>

<section class="media entries">
	<header class="media-header entries-header">
		<h1 class="heading entries-heading"><?php printf(__d('aggregator', 'Entries for feed %s', true), $feed['Feed']['title']);?></h1>
	</header>
	<div class="media-body entries-body">
	<?php if (!$entries): ?>
		<p><?php __d('aggregator', 'There are No entries in this feed.'); ?></p>
	<?php else: ?>
		<?php foreach ($entries as $entry): ?>
			<?php echo $this->Aggregator->entry($entry, 'none'); ?>
		<?php endforeach ?>
	</div>
	<footer class="media-footer entries-footer">
		<?php echo $this->Page->paginator('mh-public-paginator'); ?>
	</footer>
	<?php endif; ?>
</section>
