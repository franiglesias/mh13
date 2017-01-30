<?php 
	$params = $this->Paginator->params();
	if (!isset($params['pageCount']) || $params['pageCount'] <= 1) {
		return;
	}
?>

<div class="mh-pagination right">
	<span class="counter"><?php echo $this->Paginator->counter(array('format' => __('Count: %count%. Page %page% of %pages%.', true)));?></span>
	<ul>
	<?php echo $this->Paginator->prev('', array('class' => 'arrow-left arrow', 'tag' => 'li'), null, array('tag' => 'li', 'class'=>'current arrow-left arrow'));?>
	<?php echo $this->Paginator->next('', array('class' => 'arrow-right arrow', 'tag' => 'li'), null, array('tag' => 'li', 'class'=>'current arrow-right arrow'));?>
	</ul>
</div>