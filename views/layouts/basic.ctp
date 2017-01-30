<!doctype html>
<html class="no-js" lang="en">
	<?php echo $this->Page->block('page/head'); ?>
  <body>
	  <script>
	    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	    ga('create', 'UA-11787509-1', 'auto');
	    ga('send', 'pageview');

	  </script>
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
