<?php
	$items = $this->requestAction(
	array('plugin' => 'contents', 'controller' => 'items', 'action' => 'catalog'),
	array(
		'named' => 	array(
			'channelList' => $this->Channel->value('id'),
			'featured' => true
			)
		)
	);
?>
<div class="mh-widget">
	<header>
		<h1 class="fi-archive"><?php __d('contents', 'Featured'); ?></h1>
		<p><?php __d('contents', 'Recently featured articles in this channel.'); ?></p>
	</header>
	<div class="body">
		<?php if ($items): ?>
		<?php
			$this->Items->bind($items);
			$this->Items->attach($this->Item);
	
			$B = LayoutFactory::get('List', $this->Items);
			echo $B->withTitle('')
					->usingLayout('items/layouts/body_list')
					->usingTemplate('items/templates/linked_list')
					->withFooter()
					->render();
		?>	
		<?php else: ?>
		  	<?php echo $this->Channel->noContent(); ?>
		<?php endif; ?>
	</div>
</div>