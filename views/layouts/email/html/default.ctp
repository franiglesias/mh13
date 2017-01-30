<!-- File: /app/views/layouts/email/html/default.ctp -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title_for_layout;?></title>
</head>
<body>
	<?php echo $content_for_layout;?>
	<hr />
	<p><strong><a href="<?php echo Router::url('/', true); ?>"><?php echo Configure::read('Site.title'); ?></a></strong> <?php echo Configure::read('Site.tagline'); ?></p>
	<p>Este es un mensaje automático. Por favor, no responda a esta dirección.</p>
	<p>Para cualquier consulta, <a href="mailto:<?php echo Configure::read('Mail.from'); ?>?subject=Respuesta a correo automático">contacta con nosotros.</a></p>
</body>
</html>
