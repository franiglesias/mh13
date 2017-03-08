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
		<div class="medium-8 columns" data-equalizer-watch>
		<?php echo $content_for_layout; ?>
		</div>
		<div id="home-navigation-column" class="medium-4 columns" data-equalizer-watch>
			<?php echo $this->Page->block('/contents/sites/description');?>
			<?php echo $this->Page->block('/contents/sites/channels');?>
			<?php echo $this->Page->block('/circulars/events/next', array(<pre>{{ dump(Paging) }}</pre>
				'cache' => '+2 days'
			));?>
			<?php echo $this->Page->block('/cantine/today', array(
				'cache' => '+12 hour'
			)); ?> 
			<?php echo $this->Page->block('/uploads/collection', array(
				'slug' => 'programas', 
				'columns' => 1,
				'width' => '480',
				'cache' => '+3 week'
				)); ?>

			<?php echo $this->Page->block('/circulars/circulars/current', array(
				'cache' => '+2 days'
			)); ?>

			<?php echo $this->Page->block('miralba/proyectos'); ?>
		</div>
	</div>
	
	<?php echo $this->Page->block('page/foot', compact('scripts_for_layout')); ?>
  </body>
</html>
