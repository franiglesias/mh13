<?php echo $content_for_layout;?>

--
<?php echo Configure::read('Site.title'); ?> -- <?php echo Router::url('/', true); ?> 
<?php echo Configure::read('Site.tagline'); ?> 

Automatic message / Mensaje automático. Para cualquier consulta: <?php echo Configure::read('Mail.from'); ?>