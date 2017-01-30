<?php
/**
 * Retrieve data for the dashboard panel. 
 * Extract the CanCreate key if present to allow adding a button to allow user to directly create new Items
 */
	$items = $this->requestAction(array('plugin' => 'contents', 'controller' => 'items', 'action' => 'dashboard'));
	
	if ($items == 'disable') {
		return false;
	} 

	
	$canCreate = $items['CanCreate'];
	$count = $items['count'];
	unset($items['CanCreate'], $items['count']);
	
	$statusClass = array(
		0 => 'mh-limited',
		1 => 'mh-allowed',
	);

?>
<div class="mh-dashboard-widget">
<header>
	<h1 class="fi-page-edit"><?php __d('contents', 'Your Pending Items'); ?>
		<span><?php printf(__d('contents', '# %s', true), $count); ?></span>
	</h1>
</header>

<div>
<?php if (empty($items)): ?>
	<?php echo $this->Page->block('/ui/nocontent', array(
		'message' => __d('contents', 'You have no items pending.', true)
	)); ?>
<?php else: ?>
	<ul class="mh-dashboard-list">
	<?php foreach ($items as $item): ?>
		<?php
		$class = $statusClass[$item['Item']['real_status']];
		$label = $item['Item']['title'];
		$options = array();
		if (!empty($item['Item']['remarks'])) {
			$class = 'mh-forbidden fi-lightbulb has-tip';
			$options = array(
				'data-tooltip' => true,
				'aria-haspopup' => true,
				'title' => sprintf(__d('contents', 'Editor\'s note: %s', true), $item['Item']['remarks'])
				);
		}
		
		$options['class'] = $class;
		$options['escape'] = false
		
		?>
		<li><?php echo $this->Html->link(
				$label,
				array('plugin' => 'contents', 'controller' => 'items', 'action' => 'edit', $item['Item']['id']),
				$options
				);
		?>
		</li>
	<?php endforeach ?>
	</ul>
<?php endif; ?>
</div>

<footer>
	<ul class="mh-dashboard-legend">
		<li><p class="mh-allowed"><?php __d('contents', 'Ready to review'); ?></p></li>
		<li><p class="mh-limited"><?php __d('contents', 'Draft'); ?></p></li>
		<li><p class="mh-forbidden fi-lightbulb"><?php __d('contents', 'Has editor notes'); ?></p></li>
	</ul>
<?php if ($canCreate): ?>
	<p><?php echo $this->Html->link(
		__d('contents', 'Do you want to create a new Item?', true),
		array('plugin' => 'contents', 'controller' => 'items', 'action' => 'add'),
		array('class' => 'mh-dashboard-button')
		) ?></p>
<?php endif; ?>	
</footer>


</div>