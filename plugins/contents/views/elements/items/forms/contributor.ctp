<dl class="tabs" data-tab>
	<dd class="active"><a href="#tabs-contents"><?php __d('contents', 'Contents'); ?></a></dd>
	<dd><a href="#tabs-files"><?php __d('contents', 'Images and files'); ?></a></dd>
	<dd><a href="#tabs-publication"><?php __d('contents', 'Publication'); ?></a></dd>
	<dd><a href="#tabs-taxonomy"><?php __d('contents', 'Taxonomy'); ?></a></dd>
</dl>
<div class="tabs-content">
	<?php echo $this->Page->block('/contents/items/forms/content_limited.tab'); ?>
	<?php echo $this->Page->block('/contents/items/forms/publication_limited.tab'); ?>
	<?php echo $this->Page->block('/contents/items/forms/taxonomy.tab'); ?>
	<?php echo $this->Page->block('/contents/items/forms/files.tab'); ?>
</div>
