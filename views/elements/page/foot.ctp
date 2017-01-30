	<?php echo $this->Page->block('mh-footer'); ?>
	
	<!-- Foundation scripts -->
    
	<?php //echo $this->Html->script('/bower_components/jquery/dist/jquery.min.js', array('inline' => true)); ?>
	<?php echo $this->Html->script('foundation.min', array('inline' => true)); ?>
	<?php echo $scripts_for_layout; ?>
	<?php echo $this->Html->script('app', array('inline' => true)); ?>
	<?php echo $this->Js->writeBuffer(); ?>
