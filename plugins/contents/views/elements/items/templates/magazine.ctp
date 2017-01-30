<li>
	<article class="<?php echo $this->Item->getClass(); ?>">
	<?php echo $this->Item->mainImage('itemListImage-'.$this->Item->value('columns')); ?>
	<span class="metadata"><span class="timestamp"><?php echo $this->Item->format('pubDate', 'date'); ?></span></span>
		<div>
			<header><h1><?php echo $this->FHtml->permalink($this->Item, 'title'); ?></h1></header>
			<div><?php echo $this->Item->format('content', 'excerpt', 40); ?></div>
		</div>
	</article>
</li>