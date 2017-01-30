<?php if (!$items): ?>
	<?php 
		$this->Page->title($this->FHtml->title($this->Channel));
		echo $this->Channel->noContent(); 
		return;
 	?>
<?php endif; ?>
<?php 
	echo $this->Channel->rss();
	$cacheKey = $this->Channel->cacheKey();
	$this->Items->bind($items);
	$this->Items->attach($this->Item);
	$B = LayoutFactory::get('List', $this->Items);
?>
<div class="mh-channel-home">
	<?php
		echo $B->withTitle($this->Page->title($this->FHtml->title($this->Channel)))
				->withFooter('')
				->usingLayout('items/layouts/feed')
				->usingTemplate('items/templates/feed')
				->render();
	?>
	<?php echo $this->Page->paginator('mh-public-paginator'); ?>
</div>