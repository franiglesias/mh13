<?php if (empty($parents)): ?>
	<?php return; ?>
<?php endif; ?>

<ul class="breadcrumbs">
<?php foreach ($parents as $parent): ?>
	<li><?php echo $this->Html->link(
		$parent['StaticParent']['title'],
		array(
			'plugin' => 'contents', 
			'controller' => 'static_pages', 
			'action' => 'view', $parent['StaticParent']['slug'])
	); ?></li>
<?php endforeach ?>
</ul>