<div class="mh-widget">
	<header>
		<h1 class="fi-megaphone"><?php echo $this->Site->value('title'); ?></h1>
	</header>
	<div class="body">
		<div class="mh-media">
			<?php echo $this->FHtml->image($this->Site, 'icon', array('class' => 'mh-media-object right', 'link' => true)); ?>
			<p class="mh-media-body"><?php echo $this->Site->value('tagline'); ?></p>
		</div>
	<?php echo $this->FHtml->image($this->Site, 'image', array('size' => 'SiteDescription', 'class' => 'mh-media-object fullwidth')); ?>
		<p><?php echo $this->Site->format('description', 'excerpt', 30); ?></p>
	</div>
	<footer>
		<?php echo $this->FHtml->permalink($this->Site, __d('contents', 'Visit', true), array('class' => 'mh-btn-view')); ?>
		<?php echo $this->Site->rssLink('RSS', 'mh-btn-rss right'); ?>
	</footer>
</div>
