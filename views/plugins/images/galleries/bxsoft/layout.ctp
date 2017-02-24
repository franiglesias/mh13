<?php
echo $this->Html->css('/ui/css/jquery.bxslider', null, array('inline' => true));
echo $this->Html->script('/ui/js/bxslider/jquery.bxslider.min', array('inline' => true));
echo $this->Html->script('/ui/js/mh-bxslider-soft', array('inline' => true));
?>
<div class="bxslider-soft">
	[[body]]
</div>