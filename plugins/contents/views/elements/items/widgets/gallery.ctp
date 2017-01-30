<?php $this->Images->attach($this->Image); ?>
<aside class="mh-page-extras" id="mh-gallery">
	<div class="mh-page-extras-container">
		<h2 class="mh-page-extras-title"><?php printf(__d('contents', 'See %s photos', true), $this->Images->count()); ?></h2>
		<div>
		<?php echo $this->Images->gallery($gallery); ?>
		</div>
	</div>
</aside>