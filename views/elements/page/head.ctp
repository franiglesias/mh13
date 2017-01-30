<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="<?php echo Configure::read('Site.title'); ?>" />
	<meta name="author" content="<?php echo Configure::read('Site.author'); ?>" />
	<meta name="Copyright" content="Copyright <?php echo Configure::read('Site.title'); ?>. All Rights Reserved." />
	<meta name="DC.title" content="<?php echo Configure::read('Site.title'); ?>" />
	<meta name="DC.subject" content="<?php echo Configure::read('Site.description'); ?>" />
	<meta name="DC.creator" content="<?php echo Configure::read('Site.author'); ?>" />
	<meta name="google-site-verification" content="" />
	<link rel="shortcut icon" href="/img/favicon.ico"/>
	<!-- This is the traditional favicon.
		 - size: 16x16 or 32x32
		 - transparency is OK
		 - see wikipedia for info on browser support: http://mky.be/favicon/ -->
	<link rel="apple-touch-icon" href="/img/custom_icon.png"/>
	<title><?php echo $title_for_layout; ?></title>
	<?php echo $this->Html->css('app', null, array('inline' => true)); ?>
	<?php echo $this->Html->script('modernizr.min.js', array('inline' => true)); ?>
	<?php echo $this->Html->script('jquery.min.js', array('inline' => true)); ?>
	<?php echo $this->Html->scriptBlock('var jsVars = '.$this->Js->object($jsVars).';'); ?>
</head>