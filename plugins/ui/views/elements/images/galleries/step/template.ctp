<li>
	<p><strong><?php echo $this->Image->value('name'); ?></strong></p>
	<p><?php echo $this->Image->value('description'); ?></p>
	<p><?php echo $this->Image->render(array('size' => 'itemBxGallery')); ?></p>
</li>