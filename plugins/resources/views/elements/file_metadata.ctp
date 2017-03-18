<?php
 	$path = $file['Upload']['path']; 
?>
<div id="upload-image-preview" class="mh-record-field"><?php echo $this->Media->preview($path, 'uploadPreviewImage') ?></div>
<div class="mh-record-field">
	<p><?php echo $this->Html->link(__('Download', true),
		array('plugin' => 'uploads', 'controller' => 'uploads', 'action' => 'download', $file['Upload']['id']),
		array('class' => 'mh-button mh-button-download mh-button-call')); ?>
	</p>
</div>
<div class="mh-record-field">
	<h2 class="mh-record-field-label"><?php echo __d('resources', 'File name', true); ?></h2>
	<p><?php echo basename($file['Upload']['path']); ?></p>
</div>
<div class="mh-record-field">
	<h2 class="mh-record-field-label"><?php echo __d('resources', 'Version', true); ?></h2>
	<p><?php echo basename($file['version']); ?></p>
</div>
<div class="mh-record-field">
	<h2 class="mh-record-field-label"><?php echo __d('resources', 'Version comment', true); ?></h2>
	<p><?php echo basename($file['comment']); ?></p>
</div>
<div class="mh-record-field">
	<h2 class="mh-record-field-label"><?php echo __d('resources', 'File type', true); ?></h2>
	<p><?php echo $this->Media->humanFileType($path); ?></p>
</div>
<div class="mh-record-field">
	<h2 class="mh-record-field-label"><?php echo __d('resources', 'File size', true); ?></h2>
	<p><?php echo $this->Number->toReadableSize($file['Upload']['size']); ?></p>
</div>
<div class="mh-record-field">
	<h2 class="mh-record-field-label"><?php echo __d('resources', 'Uploader', true); ?></h2>
	<p><?php echo $users[$file['user_id']]; ?></p>
</div>
	
<div class="mh-record-field">
	<h2 class="mh-record-field-label"><?php echo __d('resources', 'Upload date', true); ?></h2>
	<p><?php echo $this->Time->format('j-m-Y', $file['created']); ?></p>
</div>