<?php
/**
 * Retrieve data for the dashboard panel
 * Extract CanCreate key to allow user to create new Channels from the panel
 */
	
	$circulars = $this->requestAction(array(
		'plugin' => 'circulars',
		'controller' => 'circulars',
		'action' => 'current'
	));
	
?>
<div class="mh-dashboard-widget">
<header>
	<h1 class="fi-book"><?php __d('circulars', 'Recent circulars'); ?></h1>
</header>

<div>
	
<?php if ($circulars): ?>
<ul class="mh-dashboard-list">
	<?php
		$this->Circulars->bind($circulars);
		$this->Circulars->attach($this->Circular);
	?>
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
	<ul class="mh-dashboard-legend">
	</ul>
</footer>

</div>