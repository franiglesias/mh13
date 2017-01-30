<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<!doctype html>
<html class="no-js" lang="en">
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
  </head>
  <body>
	<div id="mh-messages">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('auth'); ?>
		<div id="output"></div>
	</div>
	<div class="sticky"><?php echo $this->Page->block('mh-backend-navigation'); ?></div>
	<div>
		<?php echo $content_for_layout; ?>
	</div>
	<?php echo $this->Html->script('foundation.min', array('inline' => true)); ?>
	<?php echo $scripts_for_layout; ?>
	<?php echo $this->Html->script('app', array('inline' => true)); ?>
	<?php echo $this->Js->writeBuffer(); ?>
  </body>
</html>