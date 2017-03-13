<?php
// if there is a value for direct render only the content
	if (!empty($direct)) {
		echo $content_for_layout;
		return;
	}
	
	$theHeading = __d('errors', 'Sorry, we have some problem here.', true);
	$errorCode = sprintf(__d('errors', 'Error code: %s', true) ,$code);
	$errorDesc = sprintf(__d('errors', 'Error description: %s', true) ,$name);
	$errorData = sprintf(__d('errors', 'Extra data: %s', true) ,$message);
	$techHeading = __d('errors', 'Technical stuff', true);
	$flash = $this->Session->flash('auth');
	$flash .= $this->Session->flash();
	$button = $this->Html->link(__d('errors', 'Click here to return to the previous or main page.', true), $redirect, array('class' => 'mh-btn-index'));
?>
	
<?php
$code = <<<HTML
<div class="row">
<section id="error-message" class="mh-page">
	<header>
		<h1>{$theHeading}</h1>
	</header>
	{$flash}
	<div class="body">
		{$content_for_layout}
		<p>{$button}</p>
	</div>
	<div id="technical-stuff" class="body">
	<h2 class="fi-wrench">{$techHeading}</h2>
		<p>{$errorCode}</p>
		<p>{$errorDesc}</p>
		<p>{$errorData}</p>
	</div>
</section>
</div>
HTML;

?>

<!doctype html>
<html class="no-js" lang="en">
<?php echo $this->Html->charset(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="<?php echo Configure::read('Site.title'); ?>"/>
<meta name="author" content="<?php echo Configure::read('Site.author'); ?>"/>
<meta name="Copyright" content="Copyright <?php echo Configure::read('Site.title'); ?>. All Rights Reserved."/>
<meta name="DC.title" content="<?php echo Configure::read('Site.title'); ?>"/>
<meta name="DC.subject" content="<?php echo Configure::read('Site.description'); ?>"/>
<meta name="DC.creator" content="<?php echo Configure::read('Site.author'); ?>"/>
<meta name="google-site-verification" content=""/>
<link rel="shortcut icon" href="img/favicon.png"/>
<!-- This is the traditional favicon.
     - size: 16x16 or 32x32
     - transparency is OK
     - see wikipedia for info on browser support: http://mky.be/favicon/ -->
<link rel="apple-touch-icon" href="img/custom_icon.png"/>
<title><?php echo $title_for_layout; ?></title>
<?php echo $this->Html->css('app', null, array('inline' => true)); ?>
<?php echo $this->Html->css('print', null, array('inline' => true, 'media' => 'print')); ?>
<?php echo $this->Html->script('modernizr.min.js'); ?>
<?php echo $this->Html->scriptBlock('var jsVars = '.$this->Js->object($jsVars).';'); ?>

<?php echo $this->Html->script('jquery.min.js', array('inline' => true)); ?>
<body>
	<?php echo $code; ?>
  </body>
</html>
