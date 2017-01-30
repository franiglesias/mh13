<aside class="mh-widget">
	<header>
		<h1 class="fi-rss"><?php echo $feed['Feed']['title']; ?></h1>
	</header>
	<div class="body">
		<p><?php echo $feed['Feed']['description']; ?></p>
		<p><?php echo $this->Aggregator->copyright($feed['Feed']['copyright']); ?></p>
		<p><?php echo $this->Aggregator->language($feed['Feed']['language']); ?></p>
		<p class="mh-menu-bar">
		<?php echo $this->Html->link(
			__d('aggregator', 'Visit home page', true),
			$feed['Feed']['url'],
			array('class' => 'mh-button mh-button-forward mh-button-external')
			); ?>
		<?php echo $this->Html->link(
			__d('aggregator', 'Subscribe to this Feed', true),
			$feed['Feed']['feed'],
			array('class' => 'mh-button mh-button-rss')
			); ?>
		</p>
	</div>
</aside>