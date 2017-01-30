<aside class="mh-widget">
	<header class="media-header widget-header">
		<h1 class="heading widget-heading"><?php __d('aggregator', 'Entry data'); ?></h1>
	</header>
	<div class="media-body widget-heading">
		<p><?php echo $this->Html->link(__d('aggregator', 'Read original', true), $entry['Entry']['url'], array('class' => 'mh-button mh-button-forward mh-button-external')); ?></p>
		<p><?php echo __('by', true).' '.$this->Aggregator->contact($entry); ?></p>
		<p><?php echo $this->Aggregator->status($entry['Entry']['status']); ?></p>
		<?php echo $this->Article->time($entry['Entry']['pubDate']); ?>
	</div>
</aside>