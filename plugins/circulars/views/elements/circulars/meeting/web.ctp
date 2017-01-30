<h2><?php __d('circulars', 'Meeting data'); ?></h2>
<p><?php echo $this->Event->format('place', 'string', __d('circulars', 'Place: %s', true)); ?></p>
<p><?php echo $this->Event->format($this->Event->combined(), 'string', __d('circulars', 'Date and time: %s', true)); ?></p>
<h2><?php __d('circulars', 'Outline'); ?></h2>
<?php echo $this->Event->format('description', 'html'); ?>