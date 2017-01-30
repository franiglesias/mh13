<?php 
	$this->Item->link($this->Channel, 'Channel');
?>
<li>
	<article class="<?php echo $this->Item->getClass(); ?>">
	<?php echo $this->Item->listImage(); ?>
		<div class="metadata"><span class="channel"><?php echo $this->FHtml->permalink($this->Channel, 'title'); ?></span><span class="timestamp"><?php echo $this->Item->format('pubDate', 'date'); ?></span></div>
		<header><h1><?php echo $this->FHtml->permalink($this->Item, 'title'); ?></h1></header>
		<p><?php echo $this->Item->format('content', 'excerpt', 25); ?></p>
	</article>
</li>