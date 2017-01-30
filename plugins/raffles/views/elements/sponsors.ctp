<?php

	$sponsors = $this->requestAction(array(
		'plugin' => 'raffles',
		'controller' => 'prizes',
		'action' => 'sponsors'
		)
	);

?>
<aside class="mh-widget">
<header>
	<h1><?php __d('raffles', 'Sponsors'); ?></h1>
</header>

<div class="body">
	<ul class="mh-widget-list">
	<?php foreach ($sponsors as $sponsor): ?>
		<li><?php echo $sponsor; ?></li>
	<?php endforeach ?>
	</ul>
</div>
</aside>