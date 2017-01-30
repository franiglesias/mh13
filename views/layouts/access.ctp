<!doctype html>
<html class="no-js" lang="en">
	<?php echo $this->Page->block('page/head'); ?>
  <body>
	<div class="sticky"><?php echo $this->Page->block('mh-global-navigation'); ?></div>
	<div id="mh-messages">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('auth'); ?>
		<div id="output"></div>
	</div>
	<div class="row">
		<div class="mh-page">
			<div class="medium-8 columns">
				<?php echo $content_for_layout; ?>
			</div>
			<div class="medium-4 columns">
				<?php echo $this->Page->block('/access/registration'); ?>
			</div>
		</div>
	</div>
	
	<?php echo $this->Page->block('page/foot', compact('scripts_for_layout')); ?>
  </body>
</html>
