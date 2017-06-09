<?php $this->Event->link($this->Circular, 'Circular'); ?>
<div class="mh-page">
	<div class="columns">
	<div class="small-2 columns">
		<?php echo $this->Event->calendar('startDate', 'startTime'); ?>
	</div>
	<div class="small-10 columns">
		<header>
			<h1><?php echo $this->Page->title($this->Event->value('title')); ?></h1>
		</header>
		<div class="body">
			<?php if ($this->Event->value('place')): ?>
			<h2><?php __d('circulars', 'Place'); ?></h2>
			<p><?php echo $this->Event->value('place'); ?></p>
			<?php endif; ?>
			<h2><?php __d('circulars', 'Event data'); ?></h2>
			<p><?php echo $this->Event->format('startDate', array('date' => null, 'string' => __d('circulars', 'Start Date: %s', true), 'empty' => '')); ?></p>
			<p><?php echo $this->Event->format('startTime', array('time' => null, 'string' => __d('circulars', 'Start Time: %s', true), 'empty' => '')); ?></p>
			<p><?php echo $this->Event->format('endDate', array('date' => null, 'string' => __d('circulars', 'End Date: %s', true), 'empty' => '')); ?></p>
		</div>
	</div>
	</div>
</div>
