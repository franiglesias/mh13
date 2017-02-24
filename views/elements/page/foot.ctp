	<?php echo $this->Page->block('mh-footer'); ?>

	<!-- Foundation scripts -->

	<?php //echo $this->Html->script('/bower_components/jquery/dist/jquery.min.js', array('inline' => true));?>
	<script src="/js/foundation.min.js" charset="utf-8"></script>
	<script src="/js/app.js" charset="utf-8"></script>

	<?php echo $scripts_for_layout; ?>
	<?php echo $this->Js->writeBuffer(); ?>
