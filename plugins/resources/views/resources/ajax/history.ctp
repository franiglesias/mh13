<h2 class="mh-record-field-label"><?php __d('resources', 'History'); ?></h2>
<?php echo $this->Page->block('/resources/version_history', array(
	'versions' => $resource['Version'],
	'current' => $resource['Current']['version']
)); ?>
