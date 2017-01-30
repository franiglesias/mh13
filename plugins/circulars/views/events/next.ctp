<?php
	$this->Events->attach($this->Event);
?>
<div class="mh-page">
	<div class="columns">
	<header>
		<h1><?php echo $this->Page->title(__d('circulars', 'Next events', true).' '.Configure::read('SchoolYear.string')); ?></h1>
	</header>
	<div class="body">
		<!-- Content here -->
	<?php if (!$this->Events->count()): ?>
		<?php echo $this->Page->block('/Ui/nocontent'); ?>
	<?php else: ?>
		<ul class="mh-calendar-events-list">
			<?php while ($this->Events->hasNext()): ?>
			<?php $this->Events->next(); ?>
			<li class="row">
				<div class="small-3 medium-2 columns">
					<?php echo $this->Event->calendar('startDate', 'startTime'); ?>
				</div>
				<div class="small-9 medium-10 columns">
					<header>
						<h2><?php echo $this->FHtml->permalink($this->Event, 'title'); ?></h2>
					</header>
					<p><?php echo $this->Event->format('description', 'html'); ?></p>
				</div>
			</li>
			<?php endwhile ?>
		</ul>
	<?php endif ?>	  	 
	</div>
	<footer><?php echo $this->Page->paginator('mh-public-paginator'); ?></footer>
	</div>
</div>