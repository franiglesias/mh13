<div class="mh-page">
	<header>
		<h1><?php __d('aggregator', 'Thank you'); ?></h1>
		<h2><?php __d('aggregator', 'For your suggestion'); ?></h2>
	</header>
	<div class="body">
		<!-- Content here -->
		<h2><?php __d('aggregator', 'We will review the feed you submitted and activate it if appropriate.'); ?></h2>
		<p><?php __d('aggregator', 'Please, give us some time to review the feed. After approval, the feed will appear in the site the next automated refreshing cycle.') ?></p>
		<?php if (isset($returnTo)): ?>
			<p><?php echo $this->Html->link(__('Return', true), $returnTo); ?></p>
		<?php endif; ?>
	</div>
</div>

