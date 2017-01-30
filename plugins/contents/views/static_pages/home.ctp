<?php 
	$this->Page->title($this->StaticPage->value('title').' @ ' . Configure::read('Site.title'));
	$this->StaticPage->link($this->Images, 'Image');
	$this->StaticPage->link($this->Image, 'MainImage');
?>

<article class="mh-page">
	<?php echo $this->Page->isPreview(); ?>
	<?php echo $this->Page->block('/contents/items/widgets/header', array(
		'imagePath' => $this->Image->value('path'), 
		'title' => $this->StaticPage->value('title')
	)); ?>
	<div class="row medium-collapse">
		<div class="small-12 medium-7 columns">
			<?php echo $this->StaticPage->format('content', 'parse'); ?>

			<?php
				if ($this->Images->count() > 1) {
					$this->Images->attach($this->Image);
					echo $this->Page->block('/contents/items/widgets/gallery', array(
						'gallery' => $this->StaticPage->value('gallery')
					));
				}
			?>

			<?php echo $this->Page->block('/contents/items/widgets/multimedia', array(
								'item' => $staticPage
							)); ?>

			<?php echo $this->Page->block('/contents/items/widgets/downloads', array(
								'item' => $staticPage
							)); ?>

			<?php if (count($items)): ?>
			<div id="mh-page-static-related" class="mh-page-extras">
				<div class="mh-page-extras-container">
					<h2 class="mh-page-extras-title"><?php echo $this->StaticPage->value('title'); ?></h2>
					<?php echo $this->Page->block('/contents/home-main', array(
						'items' => $items,
						'title' => false,
						'template' => 'mag',
						'maxColumns' => 4,
						'fullFirst' => false,
						'itemTemplate' => 'magazine',
						'meta' => '',
						'type' => 'static',
						)); ?>
				</div>
			</div>
			<?php endif ?>
			<div id="mh-page-dinamic-related" class="mh-page-extras">
				<?php echo $this->Page->block('/contents/home-main', array(
					'items' => null,
					'title' => __d('contents', 'Related content in this site', true),
					// 'tag' => $this->StaticPage->value('project_key'),
					'label' => $this->StaticPage->value('project_key'),
					'paginate' => false,
					'layout' => 'items/layouts/feed',
					'template' => 'items/templates/combifeed',
					'maxColumns' => 4,
					'fullFirst' => false,
					'meta' => '',
					'type' => 'item'
					)); ?>
			</div>
		</div>
		<section class="small-12 medium-4 columns">
			<?php

			$template = $this->Html->link(':title', array(
				'plugin' => 'contents', 
				'controller' => 'static_pages', 
				'action' => 'view', ':slug'
				));

			?>

			<?php if (count($descendants)): // Build related pages section ?>
				<?php echo $this->Page->block('/contents/items/widgets/related', array(
					'related' => $descendants,
					'model' => 'StaticDescendant',
					'template' => $template,
					'title' => __d('contents', 'Detailed Information', true)
				)); ?>
			<?php endif ?>

			<?php if (count($siblings)): // Build related pages section ?>
				<?php echo $this->Page->block('/contents/items/widgets/related', array(
					'related' => $siblings,
					'model' => 'StaticPage',
					'template' => $template,
					'title' => __d('contents', 'Related Pages', true)
				)); ?>
			<?php endif ?>

			</section>
	</div>
</article>
