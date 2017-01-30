<?php
	$dates = array(
		'start' => date('j/m/Y', $range['start']),
		'end' => date('j/m/Y', $range['end']),
	);
	$title = String::insert(__d('cantine', 'Menu from :start to :end', true), $dates);
?>
<article>
	<header>
		<h1><?php echo $this->Page->title($title); ?></h1>
	</header>
	<div class="body">
		<?php echo $this->Cantine->table($result, $range); ?>
	</div>
</article>