<?php
	echo $this->Site->rss();
	$cacheKey = $this->Site->cacheKey();
	$this->Site->link($this->Channels, 'Channel');
?>
<div class="mh-channel-home">
	<?php echo $this->Page->block('/contents/home-main', array(
		'siteName' => $this->Site->value('key'),
		'title' => $this->Page->title($this->FHtml->title($this->Site)),
		'template' => '/contents/items/templates/combifeed',
		'layout' => '/contents/items/layouts/feed',
		'engine' => 'List',
		'sticky' => false,
		'paginate' => true,
		)); ?>
</div>