<?php 
	$this->Page->browserTitle($this->StaticPage->value('title').' @ ' . Configure::read('Site.title'));
	
	$this->StaticPage->link($this->Images, 'Image');
	$this->StaticPage->link($this->Image, 'MainImage');

	$parents = $this->StaticPage->DataProvider->getKeyDataSet('Parents');
	$siblings = $this->StaticPage->DataProvider->getKeyDataSet('Siblings');
	$descendants = $this->StaticPage->DataProvider->getKeyDataSet('Descendants');
?>

<article class="mh-page">
	<?php echo $this->Page->isPreview(); ?>
	<?php echo $this->Page->block('/contents/static_pages/blocks/breadcrumbs', array('parents' => $parents)); ?>
	<?php
	$template = 'full';
	
	if (!$this->Image->value('path')) {
		$template = 'plain'; 
	}
	
	echo $this->Page->block('/ui/headers/'.$template, array(
		'title' => $this->StaticPage->value('title'),
		'tagline' => false,
		'image' => $this->Image->value('path'),
		'icon' => false,
		'author' => false,
		'imageOptions' => array(
			'size' => 'itemMainImage',
			'filter' => array('blur' => 10)
		),
		'url' => false,
		'parent' => false
	));
	
	
	?>
	<div class="row">
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
								'item' => &$staticPage
							)); ?>
			<?php echo $this->Page->block('/contents/items/widgets/downloads', array(
								'item' => &$staticPage
							)); ?>
			<?php if ($this->StaticPage->value('project_key')): ?>
			<div id="mh-page-dinamic-related" class="mh-page-extras">
				<?php echo $this->Page->block('/contents/home-main', array(
					'items' => null,
					'title' => __d('contents', 'Related content in this site', true),
					'label' => $this->StaticPage->value('project_key'),
					'paginate' => false,
					'layout' => 'items/layouts/feed',
					'template' => 'items/templates/combifeed',
					)); ?>
			</div>
			<?php endif; ?>
			
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



	
