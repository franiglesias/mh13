<?php
/**
 * planets/all.ctp
 * 
 * This element display a list of all planets in the aggregator
 *
 * @package aggregator.milhojas
 * @version $Rev$
 * @license MIT License
 * 
 * $Id$
 * 
 * $HeadURL$
 * 
 **/




$planets = $this->requestAction(array(
		'plugin' => 'aggregator',
		'controller' => 'planets',
		'action' => 'all'
		)
	);

?>
<aside class="mh-widget">
	<header>
		<h1 class="fi-web"><?php __d('aggregator', 'Planets'); ?></h1>
	</header>

	<div id="planet-list" class="body">
		<?php if ($planets): ?>
			<ul class="mh-catalog-list">
		<?php foreach ($planets as $planet): ?>
				<li>
					<?php echo $this->Html->link(ucfirst($planet['Planet']['title']), array(
							'plugin' => 'aggregator',
							'controller' => 'entries',
							'action' => 'planet',
							$planet['Planet']['slug']
							)
					);
					?>
				</li>
		<?php endforeach ?>
			</ul>
		<?php else: ?>
			<p><?php __d('aggregator', 'Sorry. We haven\'t planets in the aggregator yet.'); ?></p>
		<?php endif; ?>
	</div>
</aside>