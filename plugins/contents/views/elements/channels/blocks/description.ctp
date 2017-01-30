<div class="mh-widget">
	<header>
		<h1 class="fi-megaphone"><?php echo $this->Channel->value('title'); ?></h1>
	</header>
	<div class="body">
		<div class="mh-media">
			<?php echo $this->FHtml->image($this->Channel, 'icon', array('class' => 'mh-media-object right', 'link' => true)); ?>
			<p class="mh-media-body"><?php echo $this->Channel->value('tagline'); ?></p>
		</div>
	<?php echo $this->FHtml->image($this->Channel, 'image', array('size' => 'channelDescription', 'class' => 'mh-media-object fullwidth')); ?>
		<p><?php echo $this->Channel->format('description', 'excerpt', 30); ?></p>
	</div>
	<footer>
		<?php echo $this->FHtml->permalink($this->Channel, __d('contents', 'Visit', true), array('class' => 'mh-btn-view')); ?>
		<?php echo $this->Channel->rssLink('RSS', 'mh-btn-rss right'); ?>
	</footer>
</div>
