<?php
/**
 * Retrieve data for the dashboard panel
 * Extract CanCreate key to allow user to create new Channels from the panel
 */
	$channels = $this->requestAction(array(
		'plugin' => 'contents', 
		'controller' => 'channels', 
		'action' => 'dashboard'
	));
	
	if ($channels == 'disable') {
		return false;
	} 
	
	$canCreate = $channels['CanCreate'];
	unset($channels['CanCreate']);
	
?>
<div class="mh-dashboard-widget">
<header>
	<h1 class="fi-book"><?php __d('contents', 'Your Channels'); ?></h1>
</header>

<div>
<?php if ($channels): ?>
	<ul class="mh-dashboard-list">
	 <?php foreach ($channels as $channel): ?>
		<li><?php switch ($channel['Owner']['access']) {
			case Channel::OWNER:
				echo $this->Html->link(
					$channel['Channel']['title'],
					array('plugin' => 'contents', 'controller' => 'channels', 'action' => 'edit', $channel['Channel']['id']), array(
						'class' => 'mh-allowed'
					));
				break;
			default:
				echo $this->Html->tag('p', 
					$channel['Channel']['title'], 
					array('class' => 'mh-forbidden')
				);
				break;
		} ?></li>
	 <?php endforeach ?>
	</ul>
<?php endif; ?>
</div>

<footer>
	<ul class="mh-dashboard-legend">
		<li><p class="mh-allowed"><?php __d('contents', 'Owned by you'); ?></p></li>
		<li><p class="mh-forbidden"><?php __d('contents', 'You can write'); ?></p></li>
	</ul>
	<?php if ($canCreate): ?>
	<p><?php echo $this->Html->link(
		__d('contents', 'Do you want to create a new Channel?', true),
		array('plugin' => 'contents', 'controller' => 'channels', 'action' => 'add'),
		array('class' => 'mh-dashboard-button')
		); ?></p>
	<?php endif; ?>
</footer>

</div>