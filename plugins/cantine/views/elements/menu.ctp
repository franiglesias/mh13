<?php

	$options = array(
		'today' => array(
			'label' => __d('cantine', 'Today', true),
			'link' => array('plugin' => 'cantine',
				'controller' => 'cantine',
				'action' => 'today'
			)
		),
		'week' => array(
			'label' => __d('cantine', 'A week from now', true),
			'link' => array('plugin' => 'cantine',
				'controller' => 'cantine',
				'action' => 'week'
			)
		),
		'this-week' => array(
			'label' => __d('cantine', 'This week', true),
			'link' => array('plugin' => 'cantine',
				'controller' => 'cantine',
				'action' => 'week',
				'this'
			)
		),
		'month' => array(
			'label' => __d('cantine', 'A month from now', true),
			'link' => array('plugin' => 'cantine',
				'controller' => 'cantine',
				'action' => 'month',
			)
		),
		'this-month' => array(
			'label' => __d('cantine', 'This month', true),
			'link' => array('plugin' => 'cantine',
				'controller' => 'cantine',
				'action' => 'month',
				'this'
			)
		)
	);
?>

<aside class="mh-widget">
	<header>
		<h1><?php __d('cantine', 'More menus'); ?></h1>
	</header>
	<nav class="body">
		<ul class="mh-catalog-list">
			<?php foreach ($options as $key => $option): ?>
				<li>
				<?php 
					$label = $this->Html->tag('span', $option['label'], array('class' => 'mh-catalog-list-item-main'));
					$label = $this->Html->tag('span', '', array('class' => 'mh-catalog-list-item-prefix short fi-calendar')).$label;
					echo $this->Html->link($label, $option['link'], array('escape' => false)); 
				?>
				</li>
			<?php endforeach ?>
		</ul>
	</nav>
</aside>