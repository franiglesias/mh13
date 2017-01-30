<?php
	$events = $this->requestAction(array(
		'plugin' => 'circulars',
		'controller' => 'events',
		'action' => 'next'
	), array(
		'pass' => array(Configure::read('Theme.limits.widget'))
	));
?>
<aside class="mh-widget">
	<header>
		<h1 class="fi-calendar"><?php __d('circulars', 'Next events'); ?></h1>
		<p><?php __d('circulars', 'Events to take place in the next days'); ?></p>
	</header>
	<div class="body">
	<?php if ($events): ?>
		<?php
			$this->Events->bind($events);
			$this->Events->attach($this->Event);
		?>
		<ul class="mh-catalog-list">
		<?php foreach ($events as $event): ?>
				<li class="mh-catalog-list-item">
					<?php
						$thePrefix = $this->Html->tag('span', $this->Time->format(DATE_EXTRA_SHORT, $event['Event']['startDate']), array('class' => 'mh-catalog-list-item-prefix'));

						$theLine = $event['Event']['title'];
						$theLine = $this->Html->tag('span', $theLine, array('class' => 'mh-catalog-list-item-main'))
					?>
					<?php echo $this->Html->link(
							$thePrefix.$theLine,
							array(
								'plugin' => 'circulars',
								'controller' => 'events',
								'action' => 'view',
								$event['Event']['id']
							),
							array('escape' => false)
							); ?>
				</li>
			
		<?php endforeach ?>
		</ul>
	<?php else: ?>
		<?php echo $this->Page->block('/ui/nocontent', array('message' => __d('circulars', 'There are no events to show', true))); ?>
	<?php endif; ?>
	</div>
	<footer>
		<?php echo $this->Html->link(
			__d('circulars', 'More events', true),
			array(
				'plugin' => 'circulars',
				'controller' => 'events',
				'action' => 'next'
			),
			array('class' => 'mh-btn-index')
		); ?>
	</footer>
</aside>