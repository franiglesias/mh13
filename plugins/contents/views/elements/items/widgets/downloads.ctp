<aside class="mh-page-extras" id="mh-downloads">
	<div class="mh-page-extras-container">
	<?php if ((!empty($item['Enclosure']) && $item['Enclosure']['type'] === 'application/pdf') || count($item['Download'])): ?>
		<h2 class="mh-page-extras-title"><?php __d('contents', 'Download'); ?></h2>
		<?php echo $this->Media->downloads($item['Download']); ?>
	<?php endif ?>
	</div>
</aside>