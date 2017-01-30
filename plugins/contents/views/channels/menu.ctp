<?php 
	$this->Channels->attach($this->Channel); 
	$title = sprintf(__dn('contents', 'There is only %s channel available.', 'There are %s channels available', $this->Channels->count(),true), $this->Channels->count());
	$B = LayoutFactory::get('List', $this->Channels);
?>
<div class="mh-page mh-channels">
	<div class="small-12 columns">
	<header>
		<h1><?php echo $this->Page->title(sprintf(__d('contents', 'All channels in %s', true), Configure::read('Site.title'))); ?></h1>
	</header>
	<?php
		echo $B->withTitle($title)
				->withFooter('')
				->usingLayout('channels/layout')
				->usingTemplate('channels/blocks/blog')
				->render();
	?></div>
</div>