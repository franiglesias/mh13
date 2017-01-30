<?php
	$circulars = $this->requestAction(array(
		'plugin' => 'circulars',
		'controller' => 'circulars',
		'action' => 'current'
	));
?>
<aside class="mh-widget">
	<header>
		<h1 class="fi-mail"><?php __d('circulars', 'Latest Circulars'); ?></h1>
		<p><?php __d('circulars', 'Currently vigent published circulars'); ?></p>
	</header>
	<div class="body">
		<?php if ($circulars): ?>
		<?php
			$this->Circulars->bind($circulars);
			$this->Circulars->attach($this->Circular);
		?>
		<ul class="mh-catalog-list">
		<?php while ($this->Circulars->hasNext()): ?>
			<?php $this->Circulars->next(); ?>
			<li><a href="<?php echo $this->Circular->self(); ?>">
				<span class="mh-catalog-list-item-prefix"><?php echo $this->Circular->format('pubDate', 'shortDate'); ?></span>
				<span class="mh-catalog-list-item-main">
					<?php echo $this->Circular->value('title'); ?>
					<small><?php echo $this->Circular->value('addressee'); ?></small>
					<small><?php //echo $circular['CircularType']['title']; ?></small>
				</span>
				</a>
			</li>
		<?php endwhile ?>
		</ul>
	
		<?php else: ?>
			<?php echo $this->Page->block('/ui/nocontent', array('message' => __d('circulars', 'There are no events to show', true))); ?>
		<?php endif; ?>
	</div>
	<footer>
		<?php echo $this->Html->link(
			__d('circulars', 'Current circulars', true),
			array(
				'plugin' => 'circulars',
				'controller' => 'circulars',
				'action' => 'current'
			),
			array('class' => 'mh-btn-index')
		); ?>
	</footer>
</aside>