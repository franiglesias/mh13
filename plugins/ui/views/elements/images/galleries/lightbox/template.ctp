<li class="<?php echo ($this->Images->cut(4) == true ? 'clearing-featured-img th' : 'th'); ?>">
	<a href="<?php echo Router::url('/', true).$this->Image->value('path'); ?>"><?php echo $this->Image->render(array('size' => 'itemGalleryThumb', 'attr' => array('data-caption' => $this->Image->caption()))); ?></a>
</li>