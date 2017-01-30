<?php $this->Channels->attach($this->Channel); ?>
<aside class="mh-widget">
	<header>
		<h1 class="fi-megaphone"><?php printf(__d('contents', 'Channels in <strong>%s</strong>', true), $this->Site->value('title')); ?></h1>
	</header>
	<div class="body">
		<?php while ($this->Channels->hasNext()): ?>
		<?php $this->Channels->next(); ?>		
			<?php echo $this->FHtml->permalink($this->Channel, 'title', array('class' => 'mh-btn-view')); ?>
		<?php endwhile ?>
	</div>
</aside>