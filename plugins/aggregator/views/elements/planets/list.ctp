<aside class="mh-widget">
	<header>
		<h1 class="fi-web"><?php __d('aggregator', 'Planets'); ?></h1>
	</header>
	<div class="body">
		<?php if ($planets): ?>
			<ul class="mh-catalog-list">
			<?php foreach ($planets as $planet): ?>
				<li>
					<?php echo $this->Html->link($planet['Planet']['title'], array('action' => 'planet', $planet['Planet']['slug'])); ?></li>
			<?php endforeach ?>
			</ul>
		<?php endif; ?>
	</div>
</aside>