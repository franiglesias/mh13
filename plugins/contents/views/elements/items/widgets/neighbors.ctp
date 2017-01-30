<aside class="mh-widget">
	<header>
		<h1><?php __d('contents', 'Previous and next'); ?></h1>
	</header>
	<div class="body">
		<?php echo $this->Post->neighbors($neighbors, array('tag' => 'p')); ?>
	</div>
</aside>

