<?php

	$comments = $this->requestAction (array(
		'plugin' => 'contents',
		'controller' => 'items',
		'action' => 'comments'
	));

	if ($comments == 'disable') {
		return false;
	} 

	$count = count($comments);
?>
<div class="mh-dashboard-widget">

<header>
	<h1 class="fi-comments"><?php __d('comments', 'Comments waiting'); ?>
		<span class="right"><?php printf(__d('contents', '# %s', true), $count); ?>
		</span>
	</h1>
</header>

<div>
<?php if ($comments): ?>
	<ul class="mh-dashboard-list">
	 <?php foreach ($comments as $comment): ?>
		<li class="menu-list-item">
			<?php echo $this->Html->link(
				$comment['Comment']['comment'],
				array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'edit', $comment['Comment']['id']),
				array('class' => 'mh-limited')
				); ?>
		</li>
	 <?php endforeach ?>
	</ul>
<?php else: ?>
	<?php echo $this->Page->block('/ui/nocontent', array(
		'message' => __d('comments', 'You have no comments waiting for approval.', true)
	)); ?>
<?php endif; ?>
</div>

<footer>
</footer>

</div>