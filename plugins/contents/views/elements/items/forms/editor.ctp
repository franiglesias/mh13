<dl class="tabs" data-tab>
	<dd class="active"><a href="#tabs-contents"><?php __d('contents', 'Contents'); ?></a></dd>
	<dd><a href="#tabs-files"><?php __d('contents', 'Images and files'); ?></a></dd>
	<dd><a href="#tabs-publication"><?php __d('contents', 'Publication'); ?></a></dd>
	<dd><a href="#tabs-taxonomy"><?php __d('contents', 'Taxonomy'); ?></a></dd>
	<dd><a href="#tabs-authoring"><?php __d('contents', 'Authoring'); ?></a></dd>
	<dd><a href="#tabs-access"><?php __d('contents', 'Access'); ?></a></dd>
</dl>
<div class="tabs-content">
	<?php echo $this->Page->block('/contents/items/forms/content.tab'); ?>
	<?php echo $this->Page->block('/contents/items/forms/publication.tab'); ?>
	<?php echo $this->Page->block('/contents/items/forms/taxonomy.tab'); ?>
	<?php echo $this->Page->block('/contents/items/forms/files.tab'); ?>
	<?php echo $this->Page->block('/contents/items/forms/authoring.tab'); ?>
	<?php echo $this->Page->block('/contents/items/forms/private.tab'); ?>
</div>
