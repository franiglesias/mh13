<?php $this->set(compact('entry')); ?>
<div class="mh-page">
	<div class="mh-page-header-container">
		<header>
			<h1><?php echo $this->Html->link($entry['Entry']['title'], $entry['Entry']['url']); ?></h1>
		</header>
	</div>
	<div class="mh-page-body">
		<?php echo $this->Aggregator->clean($entry['Entry']['content']); ?> 
	</div>
</div>