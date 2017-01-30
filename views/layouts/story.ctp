<!doctype html>
<html class="no-js" lang="en">
	<?php echo $this->Page->block('page/head'); ?>
  <body>
  <script>
<?php echo $this->Page->block('page/analytics'); ?>
	 
	<div class="sticky"><?php echo $this->Page->block('mh-global-navigation'); ?></div>
	<div id="mh-messages">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('auth'); ?>
		<div id="output"></div>
	</div>
	<?php echo $content_for_layout; ?>
	<?php echo $this->Page->block('page/foot', compact('scripts_for_layout')); ?>
  </body>
</html>
