<article>
	<header>
		<h1><?php echo $this->Page->title(__d('cantine', 'Menu for today', true)); ?></h1>
	</header>
	<div class="body">
		<h2><?php __d('cantine', 'Meals'); ?></h2>
		<?php echo $this->Cantine->day($result); ?>
		<h2><?php __d('cantine', 'Nutritional information (mean)'); ?></h2>
		<?php echo $this->Cantine->facts($result[0]); ?>
	</div>
</article>