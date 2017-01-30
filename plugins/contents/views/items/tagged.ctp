<section id="channel-entries" class="media entries">
	<header class="media-header entries-header">
		<h1 class="heading entries-heading"><?php printf(__d('contents', 'Entries labeled with <strong>%s</strong>', true), $term); ?></h1>
	</header>
	<div class="media-body entries-body">
	<?php echo $this->Page->block('/contents/items/catalog', array(
		'items' => $items,
		'exclude' => array('circulares', 'sala_de_profesores'), 
		'title' => sprintf(__d('contents', 'Entries labeled with <strong>%s</strong>', true), $term),
		'template' => 'mag',
		'maxColumns' => 2,
		'meta' => ':channel'
		)); ?>
	</div>
</section>
