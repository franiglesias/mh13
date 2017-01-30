<section class="media entries">
	<header class="media entries-header">
		<h1 class="heading entries-heading"><?php __d('aggregator', 'All entries');?></h1>
	</header>
	<div class="media-body entries-body">
	<?php if (!$entries): ?>
		 <p><?php __d('aggregator', 'There are No entries.'); ?></p>
	<?php else: ?>
		<?php foreach ($entries as $entry): ?>
			<?php echo $this->Aggregator->entry($entry); ?>
		<?php endforeach ?>
	</div>	
	<footer class="media-footer entries-footer">
		<?php echo $this->Page->paginator('mh-public-paginator'); ?>
	</footer>
	<?php endif; ?>
</section>
