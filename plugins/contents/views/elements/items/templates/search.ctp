<?php $this->Item->link($this->Channel, 'Channel'); ?>
<li>
	<article class="<?php echo $this->Item->getClass(); ?>">
	<?php echo $this->Item->mainImage('itemListImage'); ?>
	<div>
		<div class="metadata">
			<span class="channel"><?php echo $this->Channel->value('title'); ?></span>
			<span class="score"><?php echo $this->Item->format('score', array('precision' => 2, 'string' => __d('contents', 'Relevance: %s', true))); ?></span>
			<span class="timestamp"><?php echo $this->Item->format('pubDate', 'date'); ?></span>
		</div>
		<header><h1><?php echo $this->FHtml->permalink($this->Item, 'title'); ?></h1></header>
		<div><?php echo $this->Item->format('content', 'excerpt', 25); ?></div>
	</div>
	</article>
</li>