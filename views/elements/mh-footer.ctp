<footer>
	<div class="row">
		<div class="small-12 medium-6 large-8 columns">
			<div class="mh-media">
				<?php echo $this->Media->image(Configure::read('Site.icon'), array('size' => 'headerLogo', 'attr' => array('class' => 'mh-media-object'))) ?>
				<div class="mh-media-body mh-footer-title-block">
					<p class="mh-footer-title"><?php echo Configure::read('Site.title'); ?></p>
					<p class="mh-footer-tagline"><?php echo Configure::read('Site.tagline'); ?></p>
					<p class="mh-footer-description"><?php echo Configure::read('Site.description'); ?></p>
				</div>
			</div>
		</div>
		<div class="small-12 medium-6 large-4 columns">
			<ul class="vcard">
				<li class="fn"><?php echo Configure::read('Organization.title'); ?></li>
				<li class="street-address"><?php echo Configure::read('Organization.address'); ?></li>
				<li class="locality"><?php echo Configure::read('Organization.city'); ?></li>
				<li><span class="state"><?php echo Configure::read('Organization.state') ?></span>, <span class="zip"><?php echo Configure::read('Organization.zip') ?></span></li>
				<li class="phone">986 213 047</li>
				<li class="email"><a href="mailto:<?php echo Configure::read('Organization.email'); ?>"><?php echo Configure::read('Organization.email'); ?></a></li>
			</ul>
		</div>
	</div>
	<?php echo $this->Page->block('/menus/wbar', array('bar' => 'main')); ?>
	<div class="row">
		<?php echo $this->Page->block('/contents/channels/modules/external', array(
			'cache' => '+1 month', 
			)); ?>
		
	</div>
	<div class="row">
		<div class="small-12">
			<p class="right"><?php echo $this->Html->link(__('Powered by Milhojas. Credits', true), array('plugin' => false, 'controller' => 'pages', 'action' => 'display', 'credits')
		); ?>.</p>
		</div>
	</div>
</footer>