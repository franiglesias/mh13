<!doctype html>
<html class="no-js" lang="en">
	<?php echo $this->Page->block('page/head'); ?>
  <body>
	  <?php echo $this->Page->block('page/analytics'); ?>
	<div class="sticky"><?php echo $this->Page->block('mh-global-navigation'); ?></div>
	<div id="mh-messages">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('auth'); ?>
		<div id="output"></div>
	</div>
	<div class="mh-page">
		<div class="row">
			<div class="column">
			<?php echo $this->Channel->homeTitle(array(
				'filter' => array('blur' => 15),
				'overlay' => true
			)); ?>
			</div>
		</div>
	<div class="row">
		<?php echo $this->Channel->menu(); ?>
	</div>
	<div class="row">
		<div id="channel-main-column" class="medium-8 columns" data-equalizer-watch>
		<?php echo $content_for_layout; ?>
		</div>
		<div id="home-navigation-column" class="medium-4 columns" data-equalizer-watch>
			<?php echo $this->Page->block('/contents/channels/blocks/description'); ?>
			<?php echo $this->Page->block('/uploads/collection', array(
					'slug' => 'patrocinadores_1',
					'columns' => 2
				)); ?>
			<?php echo $this->Page->block('/contents/channels/blocks/tags'); ?>
			<?php echo $this->Page->block('/contents/channels/blocks/recent'); ?>
		</div>
	</div>
	</div>
	<?php echo $this->Page->block('page/foot', compact('scripts_for_layout')); ?>
  </body>
</html>