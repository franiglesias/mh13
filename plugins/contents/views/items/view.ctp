
<?php
    $this->Item->link($this->Channel, 'Channel');
    $this->Item->link($this->Authors, 'Authors');
    $this->Authors->attach($this->Author);
    $this->Item->link($this->Image, 'MainImage');
    $this->Item->link($this->Images, 'Image');
    $this->Page->title($this->Item->value('title').' @ '.$this->Channel->value('title'));
?>
<div class="container mh-channel-menu"><?php echo $this->Channel->menu(); ?></div>
<article class="mh-page">
	<?php echo $this->Page->isPreview(); ?>
	<?php echo $this->Page->block('/contents/items/widgets/header', array(
        'imagePath' => $this->Image->value('path'),
        'title' => $this->Item->value('title'),
    )); ?>
	<?php echo $this->Item->status(); ?>
	<div class="row">
		<div class="small-12 medium-7 columns">
			<?php
                if ($this->Images->count() == 1) {
                    echo $this->Image->render();
                }
            ?>
			<?php echo $this->Item->format('content', 'parse'); ?>
			<?php
                if ($this->Images->count() > 1) {
                    // $this->Images->attach($this->Image);
                    echo $this->Page->block('/contents/items/widgets/gallery', array(
                        'gallery' => $this->Item->value('gallery'),
                    ));
                }
            ?>

			<?php if ($showExtras): ?>
				<?php echo $this->Page->block('/contents/items/widgets/multimedia', array(
                    'item' => $item,
                )); ?>
			<?php endif ?>

			<?php if ($showExtras): ?>
				<?php echo $this->Page->block('/contents/items/widgets/downloads', array(
                    'item' => $item,
                )); ?>
			<?php endif ?>

			<?php echo $this->Comment->render('Contents.Item', $item['Item']['id'], $item['Item']['allow_comments']); ?>
		</div>
		<section class="small-12 medium-4 columns">
			<?php echo $this->Page->block('/contents/items/widgets/abstract'); ?>
			<?php echo $this->Page->block('/contents/items/widgets/mdata'); ?>
			<?php echo $this->Page->block('/contents/items/widgets/social'); ?>
			<?php echo $this->Page->block('/contents/items/widgets/tags'); ?>
			<?php echo $this->Page->block('/contents/items/widgets/neighbors', array('neighbors' => $neighbors)); ?>
			<?php echo $this->Page->block('/contents/channels/blocks/description'); ?>
			<?php echo $this->Page->block('/contents/items/widgets/license'); ?>
		</section>
	</div>
</article>
