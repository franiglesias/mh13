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
	<?php echo $this->Page->block('page/head'); ?>
  <body>
	<?php echo $code; ?>
  </body>
</html>
