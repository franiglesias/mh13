<li data-orbit-slide="<?php echo 'item-'.$item['Item']['id']; ?>">
	<div class="mh-orbit-content mh-media">
		<span class="mh-media-object right"><?php echo $this->Article->time($item['Item']['pubDate'], 'j/m/y'); ?></span>
		<div class="mh-media-header">
	<?php echo $this->Html->link(
		$item['Item']['title'],
		$permalink,
		array('escape' => false, 'class' => 'mh-media-body')
	); ?></div>
		<div class="mh-media-body"><?php echo $this->Article->excerpt($item['Item']['content'], array('size' => $size)); ?></div>
	</div>
</li>
