<?php
	$this->Circulars->attach($this->Circular);
?>
<section id="circulars-entries" class="mh-page">
	<div class="columns">
	<header>
		<h1><?php echo $this->Page->title(__d('circulars', 'Last circulars', true).' '.Configure::read('SchoolYear.string')); ?></h1>
	</header>
	<div class="body">
	<?php if (!$this->Circulars->count()): ?>
		<?php echo $this->Page->block('/Ui/nocontent'); ?>
	<?php else: ?>
		<?php while ($this->Circulars->hasNext()): ?>
		<?php $this->Circulars->next(); ?>
		<article class="row">
			<div class="small-9 columns end">
				<h2><a href="<?php echo $this->Circular->self(); ?>"><?php echo $this->Circular->value('title'); ?></a></h2>
				<p><?php echo $this->Circular->value('addressee'); ?></p>
				<p><?php echo $this->Circular->format('pubDate', array('date' => false, 'string' => __d('circulars', 'Published: %s', true))); ?></p>
				<p><?php echo $this->Circular->responseRequired(); ?></p>
			</div>
		</article>
		<?php endwhile ?>
		
	<footer><?php echo $this->Page->paginator('mh-public-paginator'); ?></footer>
	<?php endif; ?>
	</div>
</section>
