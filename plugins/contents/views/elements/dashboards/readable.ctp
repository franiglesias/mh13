<?php
/**
 * Retrieve data for the dashboard panel
 * Extract CanCreate key to allow user to create new Channels from the panel
 */
	$channels = $this->requestAction(array(
		'plugin' => 'contents', 
		'controller' => 'channels', 
		'action' => 'readable'
	));
	
	if ($channels == 'disable') {
		return false;
	} 
	
	
?>
<div class="mh-dashboard-widget">
<header>
	<h1 class="fi-book"><?php __d('contents', 'Private contents'); ?></h1>
</header>

<div>
<?php if ($channels): ?>
	<ul class="mh-dashboard-list">
	 <?php foreach ($channels as $channel): ?>
		<li><?php 
				echo $this->Html->link(
					$channel['Channel']['title'],
					array('plugin' => 'contents', 'controller' => 'channels', 'action' => 'view', $channel['Channel']['slug']), array(
						'class' => 'mh-allowed'
					));
			 ?></li>
	 <?php endforeach ?>
	</ul>
<?php endif; ?>
</div>

<footer>
	<ul class="mh-dashboard-legend">
		<li><p class="mh-allowed"><?php __d('contents', 'Private channels you can read.'); ?></p></li>
	</ul>
</footer>
</div>