<div class="mh-widget">
	<header>
		<h1><?php echo $title; ?></h2>
	</header>
	<div class="body">
		<ul class="mh-catalog-list">
		<?php echo $this->Mptt->render($related, $model, $template); ?>
		</ul>
	</p>	
</div>
