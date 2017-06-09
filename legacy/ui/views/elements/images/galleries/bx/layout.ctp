<?php
echo $this->Html->css('/ui/css/jquery.bxslider', null, array('inline' => true));
echo $this->Html->script('/ui/js/bxslider/jquery.bxslider.min', array('inline' => true));
echo $this->Html->script('/ui/js/mh-bxslider-gallery', array('inline' => true));
?>
<div class="bxslider">
	[[body]]
</div>